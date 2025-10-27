<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use App\Models\PaymentMerchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::with(['client_contacts', 'client_companies', 'client_accounts'])->get();
        $clientContacts = ClientContact::where('status', 1)->get();
        $edit_brand = session()->has('edit_brand') ? session()->get('edit_brand') : null;
        return view('admin.brands.index', compact('brands', 'edit_brand', 'clientContacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'url' => 'nullable|url',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ]);
        try {
            $brand = new Brand($request->only(['name', 'url', 'email', 'description', 'status']));
            if ($request->hasFile('logo')) {
                $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $publicPath = public_path('assets/images/brand-logos');
                $request->file('logo')->move($publicPath, $originalFileName);
                $brand->logo = $originalFileName;
            } else if ($request->logo_url) {
                $brand->logo = $request->logo_url;
            }
            $brand->save();
            DB::transaction(function () use ($request, $brand) {
                if ($request->has('client_accounts')) {
                    $selectedAccounts = $request->input('client_accounts');
                    $relatedCompanies = ClientCompany::whereHas('client_accounts', function ($query) use ($selectedAccounts) {
                        $query->whereIn('id', $selectedAccounts);
                    })->pluck('special_key')->toArray();
                    $relatedContacts = ClientContact::whereHas('client_companies', function ($query) use ($relatedCompanies) {
                        $query->whereIn('c_contact_key', $relatedCompanies);
                    })->pluck('special_key')->toArray();
                } else {
                    $selectedAccounts = [];
                    $relatedCompanies = [];
                    $relatedContacts = [];
                }
                $selectedCompanies = array_unique(array_merge($request->input('client_companies', []), $relatedCompanies));
                $selectedContacts = array_unique(array_merge($request->input('client_contacts', []), $relatedContacts));
                $brand->client_accounts()->sync($selectedAccounts);
                $brand->client_companies()->sync($selectedCompanies);
                $brand->client_contacts()->sync($selectedContacts);
            });
            return response()->json(['data' => $brand, 'message' => 'Record created successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Brand $brand)
    {
        if ($request->ajax()) {
            $brand->load(['client_contacts', 'client_companies', 'client_accounts']);
            return response()->json($brand);
        }
        session(['edit_brand' => $brand]);
        return response()->json(['data' => $brand]);
//        return redirect()->route('admin.brand.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|max:255',
            'url' => 'nullable|url',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_url' => 'nullable|url',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ]);
        try {
            $brand->fill($request->only(['name', 'email', 'description', 'status', 'url']));
            if ($request->hasFile('logo')) {
                $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $publicPath = public_path('assets/images/brand-logos');
                $request->file('logo')->move($publicPath, $originalFileName);
                $brand->logo = $originalFileName;
            } else if ($request->logo_url) {
                $brand->logo = rawurlencode($request->logo_url);
            }
            $brand->save();
            DB::transaction(function () use ($request, $brand) {
                if ($request->has('client_accounts')) {
                    $selectedAccounts = $request->input('client_accounts');
                    $relatedCompanies = ClientCompany::whereHas('client_accounts', function ($query) use ($selectedAccounts) {
                        $query->whereIn('id', $selectedAccounts);
                    })->pluck('special_key')->toArray();
                    $relatedContacts = ClientContact::whereHas('client_companies', function ($query) use ($relatedCompanies) {
                        $query->whereIn('c_contact_key', $relatedCompanies);
                    })->pluck('special_key')->toArray();
                } else {
                    $selectedAccounts = [];
                    $relatedCompanies = [];
                    $relatedContacts = [];
                }
                $selectedCompanies = array_unique(array_merge($request->input('client_companies', []), $relatedCompanies));
                $selectedContacts = array_unique(array_merge($request->input('client_contacts', []), $relatedContacts));
                $brand->client_accounts()->sync($selectedAccounts);
                $brand->client_companies()->sync($selectedCompanies);
                $brand->client_contacts()->sync($selectedContacts);
            });
            return response()->json(['data' => $brand, 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Brand $brand)
    {
        try {

            // Remove logo if exists
            if ($brand->logo) {
                if (!filter_var($brand->logo, FILTER_VALIDATE_URL)) {
//              Storage::disk('public')->delete($brand->logo);
                    $path = public_path('assets/images/brand-logos/' . $brand->logo);
                    if (File::exists($path)) {
//                        File::delete($path);
                    }
                }
            }
            if ($brand->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'Unable to process deletion request at this time.'], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function change_status(Request $request, Brand $brand)
    {
        try {
            $brand->status = $request->query('status');
            $brand->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
