<?php

namespace App\Http\Controllers\Admin\Client;

use App\Constants\PaymentMerchantConstants;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AssignBrandAccount;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use App\Models\Payment;
use App\Models\PaymentMerchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class PaymentMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::active()->orderBy('name')->get();
        $payment_merchants = PaymentMerchant::withMonthlyUsage()->get();
        $payment_merchants->each(function ($merchant) {
            $merchant->usage = number_format($merchant->payments->sum('total_amount') ?? 0);
        });
        $client_contacts = ClientContact::active()->orderBy('name')->get();
        return view('admin.payment-merchants.index', compact('payment_merchants', 'client_contacts', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        //return view('admin.payment-merchants.create', compact('brands'));
        return response()->json(['brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
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
                'bank_details' => 'nullable|string',
                'limit' => 'nullable|integer|min:1',
                'capacity' => 'nullable|integer|min:1',
                'payment_method' => 'required|string|in:authorize,edp,stripe,paypal,bank transfer',
//                'payment_method' => 'required|string|in:authorize,stripe,credit card,bank transfer,paypal,cash,other',
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
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            DB::beginTransaction();
            $data = [
                'c_contact_key' => $request->c_contact_key,
                'c_company_key' => $request->c_company_key,
                'name' => $request->name,
                'descriptor' => $request->descriptor,
                'vendor_name' => $request->vendor_name,
                'email' => $request->email,
                'payment_method' => $request->payment_method,
                'bank_details' => $request->bank_details,
                'login_id' => $request->login_id,
                'transaction_key' => $request->transaction_key,
                'limit' => $request->limit,
                'capacity' => $request->capacity,
                'description' => $request->description,
                'environment' => $request->environment,
                'status' => $request->status,
            ];
            /** Note : For testing purpose only when environment is on sandbox (in testing) */
            if ($request->input('payment_method') == 'authorize') {
//                $this->getMerchantDetails($data);
                $data['test_login_id'] = env('AUTHORIZE_NET_API_TEST_LOGIN_ID');
                $data['test_transaction_key'] = env('AUTHORIZE_NET_TEST_TRANSACTION_KEY');
            } elseif ($request->input('payment_method') == 'edp') {
                $data['test_login_id'] = env('SECURE_TEST_KEY');
                $data['test_transaction_key'] = env('SECURE_TEST_KEY');
            } elseif ($request->input('payment_method') == 'stripe') {
                $data['test_login_id'] = env('STRIPE_TEST_KEY');
                $data['test_transaction_key'] = env('STRIPE_TEST_SECRET');
            } elseif ($request->input('payment_method') == 'paypal') {
                $data['test_login_id'] = env('PAYPAL_CLIENT_ID');
                $data['test_transaction_key'] = env('PAYPAL_CLIENT_SECRET');
            }
            /** Note : For testing purpose only when environment is on sandbox (in testing) */
            $client_account = PaymentMerchant::create($data);
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
            $total_amount = Payment::where('merchant_id', $client_account->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount');
            $client_account->usage = number_format($total_amount);
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

        $assign_brand_keys = $client_account->brands()->distinct()->pluck('assign_brand_accounts.brand_key')->toArray();
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
                'bank_details' => 'nullable|string',
                'login_id' => 'nullable|string|max:255',
                'transaction_key' => 'nullable|string|max:255',
                'limit' => 'nullable|integer|min:1',
                'capacity' => 'nullable|integer|min:1',
                'payment_method' => 'required|string|in:authorize,edp,stripe,paypal,bank transfer',
//                'payment_method' => 'required|string|in:authorize,stripe,credit card,bank transfer,paypal,cash,other',
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
                'payment_method' => $request->payment_method,
                'bank_details' => $request->bank_details,
                'login_id' => $request->login_id,
                'transaction_key' => $request->transaction_key,
                'limit' => $request->limit,
                'capacity' => $request->capacity,
                'environment' => $request->environment,
                'status' => $request->status,
            ]);
            $current = $client_account->brands()->distinct()->pluck('assign_brand_accounts.brand_key')->toArray();
            $user = Auth::user();
            $requestBrands = $request->input('brands', []);
            $added = array_diff($requestBrands, $current);
            $removed = array_diff($current, $requestBrands);
            $allBrandKeys = array_unique(array_merge($requestBrands, $current));
            $brandNames = Brand::whereIn('brand_key', $allBrandKeys)->pluck('name', 'brand_key')->toArray();
            $client_account->brands()->sync($requestBrands);
            $this->logBrandSyncChanges($client_account, $added, $removed, $user, $brandNames);
//
//            AssignBrandAccount::where('assignable_type', PaymentMerchant::class)
//                ->where('assignable_id', $client_account->id)
////                    ->whereNotIn('brand_key', $brandKeys)
//                ->delete();
//            if ($request->has('brands') && !empty($request->brands)) {
//                    foreach ($request->brands as $brandKey) {
//                        AssignBrandAccount::firstOrCreate([
//                            'brand_key' => $brandKey,
//                            'assignable_type' => PaymentMerchant::class,
//                            'assignable_id' => $client_account->id,
//                        ]);
//                    }
//            }
            DB::commit();
            $client_account->refresh();
            $total_amount = Payment::where('merchant_id', $client_account->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount');
            $client_account->usage = number_format($total_amount);
            $client_account->loadMissing('client_contact', 'client_company');
            return response()->json(['data' => $client_account, 'success' => 'Record Updated Successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
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
                'description' => "{$user->name} updated brands for Client Account {$model->name}",
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
     * Showing accounts of specified resource.
     */
    public function by_brand($brand_key, $currency)
    {
        if (!$brand_key) {
            return response()->json(['error' => 'Oops! Brand not found.'], 404);
        }
        $brand = Brand::where('brand_key', $brand_key)->first();
        if (!$brand) {
            return response()->json(['error' => 'Oops! Brand not found.'], 404);
        }
        $allowedMethods = strtoupper($currency) === 'GBP' ? ['stripe', 'paypal'] : null;
        $client_accounts = $brand->client_accounts()
            ->when($allowedMethods, function ($query) use ($allowedMethods) {
                $query->whereIn('payment_method', $allowedMethods);
            })
            ->get();
        $groupedAccounts = $client_accounts
            ->map(function ($account) {
                $payment_merchant = PaymentMerchant::where('id', $account->id)->withMonthlyUsage()->first();
                $usage = number_format($payment_merchant->payments->sum('total_amount') ?? 0, 2, '.', '');
                $capacity = max(0, (float)$account->capacity);
                $limit = max(0, (float)$account->limit);
                $availableLimit = min($limit, $capacity - $usage);
                return [
                    'id' => $account->id,
                    'name' => $account->name,
                    'limit' => $availableLimit,
                    'payment_method' => $account->payment_method,
                    'capacity' => $account->capacity,
                ];
            })
            ->reject(function ($account) {
                return $account['limit'] < 1;
            })
            ->unique('id')
            ->groupBy('payment_method')
            ->map(function ($group) {
                return $group->map(function ($account) {
                    return [
                        'id' => $account['id'],
                        'name' => $account['name'],
                        'limit' => $account['limit'],
                    ];
                });
            });
        return response()->json(['data' => $groupedAccounts]);
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
