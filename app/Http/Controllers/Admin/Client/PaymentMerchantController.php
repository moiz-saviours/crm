<?php

namespace App\Http\Controllers\Admin\Client;

use App\Constants\PaymentMerchantConstants;
use App\Http\Controllers\Controller;
use App\Models\AssignBrandAccount;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use App\Models\PaymentMerchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::where('status', 1)->get();
        $payment_merchants = PaymentMerchant::get();
        $client_contacts = ClientContact::where('status', 1)->get();
        return view('admin.payment-merchants.index', compact('payment_merchants', 'client_contacts', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 1)->get();
        //return view('admin.payment-merchants.create', compact('brands'));
        return response()->json(['brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'brands' => 'nullable|array',
                'brands.*' => 'exists:brands,brand_key',
                'c_contact_key' => 'required|exists:client_contacts,special_key',
                'c_company_key' => 'required|exists:client_companies,special_key',
                'name' => 'required|string|max:255',
                'descriptor' => 'nullable|string|max:255',
                'vendor_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'login_id' => 'nullable|string|max:255',
                'transaction_key' => 'nullable|string|max:255',
                'limit' => 'nullable|integer|min:1',
                'environment' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::ENVIRONMENT_SANDBOX, PaymentMerchantConstants::ENVIRONMENT_PRODUCTION]),
                ],
                'status' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::STATUS_ACTIVE, PaymentMerchantConstants::STATUS_INACTIVE, PaymentMerchantConstants::STATUS_SUSPENDED]),
                ],
            ], [
                'brands.array' => 'Brands must be selected as an array.',
                'brands.*.exists' => 'One or more selected brands are invalid.',
            ]);
            $client_account = PaymentMerchant::create([
                'c_contact_key' => $request->c_contact_key,
                'c_company_key' => $request->c_company_key,
                'name' => $request->name,
                'descriptor' => $request->descriptor,
                'vendor_name' => $request->vendor_name,
                'email' => $request->email,
                'login_id' => $request->login_id,
                'transaction_key' => $request->transaction_key,
                'limit' => $request->limit,
                'capacity' => $request->capacity,
                'description' => $request->description,
                'environment' => $request->environment,
                'status' => $request->status,
            ]);
            if ($request->has('brands') && !empty($request->brands)) {
                foreach ($request->brands as $brandKey) {
                    AssignBrandAccount::create([
                        'brand_key' => $brandKey,
                        'assignable_type' => PaymentMerchant::class,
                        'assignable_id' => $client_account->id,
                    ]);
                }
            }
            DB::commit();
            $client_account->refresh();
            $client_account->loadMissing('client_contact', 'client_company');
            return response()->json(['data' => $client_account, 'success' => 'Record Created Successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMerchant $paymentMerchant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PaymentMerchant $client_account)
    {

        $assign_brand_keys = $client_account->brands()->pluck('assign_brand_accounts.brand_key')->toArray();
        if ($request->ajax()) {
            if (!$client_account) {
                return response()->json(['error' => 'Record not found!'], 404);
            }
            return response()->json(['client_account' => $client_account, 'assign_brand_keys' => $assign_brand_keys]);
        }
        return view('admin.payment-merchants.edit', compact('client_account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMerchant $client_account)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'brands' => 'nullable|array',
                'brands.*' => 'exists:brands,brand_key',
                'c_contact_key' => 'required|exists:client_contacts,special_key',
                'c_company_key' => 'required|exists:client_companies,special_key',
                'name' => 'required|string|max:255',
                'descriptor' => 'nullable|string|max:255',
                'vendor_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'login_id' => 'nullable|string|max:255',
                'transaction_key' => 'nullable|string|max:255',
                'limit' => 'nullable|integer|min:1',
                'capacity' => 'nullable|integer|min:1',
                'environment' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::ENVIRONMENT_SANDBOX, PaymentMerchantConstants::ENVIRONMENT_PRODUCTION]),
                ],
                'status' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::STATUS_ACTIVE, PaymentMerchantConstants::STATUS_INACTIVE, PaymentMerchantConstants::STATUS_SUSPENDED]),
                ],
            ], [
                'brands.array' => 'Brands must be selected as an array.',
                'brands.*.exists' => 'One or more selected brands are invalid.',
            ]);
            $client_account->update([
                'c_contact_key' => $request->c_contact_key,
                'c_company_key' => $request->c_company_key,
                'name' => $request->name,
                'descriptor' => $request->descriptor,
                'vendor_name' => $request->vendor_name,
                'email' => $request->email,
                'login_id' => $request->login_id,
                'transaction_key' => $request->transaction_key,
                'limit' => $request->limit,
                'capacity' => $request->capacity,
                'environment' => $request->environment,
                'status' => $request->status,
            ]);
            if ($request->has('brands')) {
                $brandKeys = $request->brands;
                AssignBrandAccount::where('assignable_type', PaymentMerchant::class)
                    ->where('assignable_id', $client_account->id)
                    ->whereNotIn('brand_key', $brandKeys)
                    ->delete();
                if (!empty($request->brands)) {
                    foreach ($request->brands as $brandKey) {
                        AssignBrandAccount::create([
                            'brand_key' => $brandKey,
                            'assignable_type' => PaymentMerchant::class,
                            'assignable_id' => $client_account->id,
                        ]);
                    }
                }
            }
            DB::commit();
            $client_account->refresh();
            $client_account->loadMissing('client_contact', 'client_company');
            return response()->json(['data' => $client_account, 'success' => 'Record Updated Successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function change_status(Request $request, PaymentMerchant $client_account)
    {
        try {
            $client_account->status = $request->query('status');
            $client_account->save();
            return response()->json(['success' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(PaymentMerchant $client_account)
    {
        try {
            if ($client_account->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'An error occurred while deleting the record.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
