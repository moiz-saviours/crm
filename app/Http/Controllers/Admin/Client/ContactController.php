<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\AssignBrandAccount;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::where('status', 1)->get();
        $client_contacts = ClientContact::all();
        return view('admin.clients.contacts.index', compact('client_contacts', 'brands'));
    }

    /**
     * Showing companies of specified resource.
     */
    public function companies($client_contact)
    {
        if (!$client_contact) {
            return response()->json(['error' => 'Oops! Contact not found.'], 404);
        }
        $client_companies = ClientCompany::where('c_contact_key', $client_contact)->where('status', 1)->get();
        return response()->json(['client_companies' => $client_companies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Cache::rememberForever('countries_list', fn() => config('countries'));
        return view('admin.clients.contacts.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brands' => 'nullable|array',
            'brands.*' => 'exists:brands,brand_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:client_contacts,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20',
        ], [
            'brands.array' => 'Brands must be selected as an array.',
            'brands.*.exists' => 'One or more selected brands are invalid.',
        ]);
        $client_contact = new ClientContact($request->only([
                'name', 'email', 'phone', 'address', 'city', 'state',
                'country', 'zipcode', 'ip_address', 'status',
            ]) + ['special_key' => ClientContact::generateSpecialKey()]);
        DB::transaction(function () use ($request, $client_contact) {
            $client_contact->save();
            if ($request->has('brands') && !empty($request->brands)) {
                foreach ($request->brands as $brandKey) {
                    AssignBrandAccount::create([
                        'brand_key' => $brandKey,
                        'assignable_type' => ClientContact::class,
                        'assignable_id' => $client_contact->special_key,
                    ]);
                }
            }
        });
        return response()->json(['data' => $client_contact, 'success' => 'Record created successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientContact $client_contact)
    {
        return response()->json(['client_contact' => $client_contact]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientContact $client_contact)
    {
        if (!$client_contact) {
            return response()->json(['error' => 'Record not found!'], 404);
        }
        $assign_brand_keys = $client_contact->brands()->pluck('assign_brand_accounts.brand_key')->toArray();
        return response()->json(['client_contact' => $client_contact, 'assign_brand_keys' => $assign_brand_keys]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientContact $client_contact)
    {
        $request->validate([
            'brands' => 'nullable|array',
            'brands.*' => 'exists:brands,brand_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:client_contacts,email,' . $client_contact->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20'
        ], [
            'brands.array' => 'Brands must be selected as an array.',
            'brands.*.exists' => 'One or more selected brands are invalid.',
        ]);
        DB::transaction(function () use ($request, $client_contact) {
            $client_contact->update($request->only([
                'name', 'email', 'phone', 'address', 'city', 'state',
                'country', 'zipcode', 'ip_address', 'status',
            ]));
            if ($request->has('brands')) {
                $brandKeys = $request->brands;
                AssignBrandAccount::where('assignable_type', ClientContact::class)
                    ->where('assignable_id', $client_contact->special_key)
                    ->whereNotIn('brand_key', $brandKeys)
                    ->delete();
                foreach ($brandKeys as $brandKey) {
                    AssignBrandAccount::firstOrCreate([
                        'brand_key' => $brandKey,
                        'assignable_type' => ClientContact::class,
                        'assignable_id' => $client_contact->special_key,
                    ]);
                }
            }
        });
        return response()->json(['data' => $client_contact, 'success' => 'Record updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(ClientContact $client_contact)
    {
        try {
            if ($client_contact->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'An error occurred while deleting the record.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, ClientContact $clientContact)
    {
        try {
            $clientContact->status = $request->query('status');
            $clientContact->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }


    /**
     * Change the specified resource status from storage.
     */
    /**
     * Change the contact status and cascade to related companies/accounts
     *
     * @param Request $request
     * @param ClientContact $clientContact
     * @return \Illuminate\Http\JsonResponse
     */
//    public function change_status(Request $request, ClientContact $clientContact)
//    {
//        try {
//            $newStatus = (int)$request->query('status');
//            $oldStatus = $clientContact->status;
//            if ($oldStatus !== $newStatus) {
//                DB::beginTransaction();
//                $companyCount = $clientContact->companies()->where('status', 1)->count();
//                $accountCount = $clientContact->companies()
//                    ->with(['client_accounts' => function ($query) {
//                        $query->where('status', 'active');
//                    }])
//                    ->get()
//                    ->sum(function ($company) {
//                        return $company->client_accounts->count();
//                    });
//                $clientContact->status = $newStatus;
//                $clientContact->save();
//                DB::commit();
//                $companyMessage = $companyCount === 1 ? '1 company' : "{$companyCount} companies";
//                $accountMessage = $accountCount === 1 ? '1 account' : "{$accountCount} accounts";
//                $message = $newStatus
//                    ? 'Contact activated successfully'
//                    : "Contact and related active records deactivated. (Affected: This Contact, {$companyMessage}, {$accountMessage})";
//                return response()->json([
//                    'success' => true,
//                    'message' => $message,
//                    'status' => $newStatus,
//                    'affected_records' => [
//                        'companies' => $clientContact->companies()->count(),
//                        'accounts' => $clientContact->companies()->with('client_accounts')->get()->sum(function ($company) {
//                            return $company->client_accounts->count();
//                        })
//                    ]
//                ]);
//            }
//            return response()->json([
//                'success' => true,
//                'message' => 'Status unchanged (already ' . ($newStatus ? 'active' : 'inactive') . ')',
//                'status' => $newStatus
//            ]);
//
//        } catch (\Exception $e) {
//            DB::rollBack();
//            Log::error('Contact status change failed', [
//                'contact_id' => $clientContact->id,
//                'error' => $e->getMessage(),
//                'trace' => $e->getTraceAsString()
//            ]);
//            return response()->json([
//                'success' => false,
//                'message' => 'Failed to update contact status',
//                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
//                'suggestion' => 'Please try again or contact support'
//            ], 500);
//        }
//    }
}
