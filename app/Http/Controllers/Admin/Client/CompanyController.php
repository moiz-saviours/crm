<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AssignBrandAccount;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $client_companies = ClientCompany::get();
        $client_contacts = ClientContact::where('status', 1)->get();
        return view('admin.clients.companies.index', compact('client_companies', 'client_contacts', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clients.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brands' => 'nullable|array',
            'brands.*' => 'exists:brands,brand_key',
            'c_contact_key' => 'required:exists:client_contacts,special_key',
            'name' => 'required|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ], [
            'brands.array' => 'Brands must be selected as an array.',
            'brands.*.exists' => 'One or more selected brands are invalid.',
        ]);
        try {
            $client_company = new ClientCompany($request->only(['name', 'email', 'c_contact_key', 'description', 'url', 'status']) + ['special_key' => ClientCompany::generateSpecialKey()]);
            if ($request->hasFile('logo')) {
                $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $publicPath = public_path('assets/images/clients/companies/logos/');
                $request->file('logo')->move($publicPath, $originalFileName);
                $client_company->logo = $originalFileName;
            }
            DB::transaction(function () use ($request, $client_company) {
                $client_company->save();
                if ($request->has('brands') && !empty($request->brands)) {
                    foreach ($request->brands as $brandKey) {
                        AssignBrandAccount::create([
                            'brand_key' => $brandKey,
                            'assignable_type' => ClientCompany::class,
                            'assignable_id' => $client_company->special_key,
                        ]);
                    }
                }
            });
            $client_company->loadMissing('client_contact');
            return response()->json(['data' => $client_company, 'message' => 'Record created successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientCompany $client_company)
    {
        return view('admin.clients.companies.show', compact('client_company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ClientCompany $client_company)
    {
        if (!$client_company) {
            return response()->json(['error' => 'Record not found!'], 404);
        }
        $assign_brand_keys = $client_company->brands()->distinct()->pluck('assign_brand_accounts.brand_key')->toArray();
        if ($request->ajax()) {
            return response()->json(['client_company' => $client_company, 'assign_brand_keys' => $assign_brand_keys]);
        }
        return view('admin.client.companies.edit', compact('client_company', 'assign_brand_keys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientCompany $client_company)
    {
        $request->validate([
            'brands' => 'nullable|array',
            'brands.*' => 'exists:brands,brand_key',
            'c_contact_key' => 'required|exists:client_contacts,special_key',
            'name' => 'required|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|url',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ], [
            'brands.array' => 'Brands must be selected as an array.',
            'brands.*.exists' => 'One or more selected brands are invalid.',
        ]);
        try {

            DB::transaction(function () use ($request, $client_company) {
                $client_company->fill($request->only(['name', 'email', 'description', 'status', 'c_contact_key', 'url']));
                if ($request->hasFile('logo')) {
                    $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                    $publicPath = public_path('assets/images/clients/companies/logos/');
                    if (!file_exists($publicPath)) {
                        mkdir($publicPath, 0777, true);
                    }
                    $request->file('logo')->move($publicPath, $originalFileName);
                    $client_company->logo = $originalFileName;
                }
                $client_company->save();
                $current = $client_company->brands()->distinct()->pluck('assign_brand_accounts.brand_key')->toArray();
                $user = Auth::user();
                $requestBrands = $request->input('brands', []);
                $added = array_diff($requestBrands, $current);
                $removed = array_diff($current, $requestBrands);
                $allBrandKeys = array_unique(array_merge($requestBrands, $current));
                $brandNames = Brand::whereIn('brand_key', $allBrandKeys)->pluck('name', 'brand_key')->toArray();
                $client_company->brands()->sync($requestBrands);
                $this->logBrandSyncChanges($client_company, $added, $removed, $user, $brandNames);
//                AssignBrandAccount::where('assignable_type', ClientCompany::class)
//                    ->where('assignable_id', $client_company->special_key)
//                    ->delete();
//                if ($request->has('brands') && !empty($request->brands)) {
//                    foreach ($request->brands as $brandKey) {
//                        AssignBrandAccount::firstOrCreate([
//                            'brand_key' => $brandKey,
//                            'assignable_type' => ClientCompany::class,
//                            'assignable_id' => $client_company->special_key,
//                        ]);
//                    }
//                }
            });
            $client_company->loadMissing('client_contact');
            return response()->json(['data' => $client_company, 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    protected function logBrandSyncChanges($model, $added, $removed, $user, $brandNames)
    {
        $addedNames = array_map(function ($key) use ($brandNames) {
            return $brandNames[$key] ?? $key;
        }, $added);
        $removedNames = array_map(function ($key) use ($brandNames) {
            return $brandNames[$key] ?? $key;
        }, $removed);
        if (!empty($added) || !empty($removed)) {
            ActivityLog::create([
                'action' => 'synced',
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'actor_type' => get_class($user),
                'actor_id' => $user->id,
                'description' => "{$user->name} updated brands for Client Company {$model->name}",
//                'description' => sprintf(
//                    "%s updated brands for %s \nAdded: %s\\nRemoved: %s",
//                    $user->name,
//                    $model->name,
//                    implode(', ', $addedNames) ?: 'none',
//                    implode(', ', $removedNames) ?: 'none'
//                ),
                'details' => json_encode([
                    'added' => array_values($addedNames),
                    'removed' => array_values($removedNames),
                    'added_keys' => array_values($added),
                    'removed_keys' => array_values($removed)
                ]),
                'ip_address' => request()->ip(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(ClientCompany $client_company)
    {
        try {
            if ($client_company->logo) {
                if (!filter_var($client_company->logo, FILTER_VALIDATE_URL)) {
//              Storage::disk('public')->delete($client_company->logo);
                    $path = public_path('assets/images/clients/companies/logos/' . $client_company->logo);
                    if (File::exists($path)) {
//                        File::delete($path);
                    }
                }
            }
            if ($client_company->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'An error occurred while deleting the record.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function change_status(Request $request, ClientCompany $client_company)
    {
        try {
            $client_company->status = $request->query('status');
            $client_company->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
