<?php

namespace App\Http\Controllers\User\Client;

use App\Constants\PaymentMerchantConstants;
use App\Http\Controllers\Controller;
use App\Models\AssignBrandAccount;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use App\Models\Payment;
use App\Models\PaymentMerchant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $payment_merchants = PaymentMerchant::withMonthlyUsage()->get();
        $payment_merchants->each(function ($merchant) {
            $merchant->usage = number_format($merchant->payments->sum('total_amount') ?? 0);
        });
        $client_contacts = ClientContact::active()->get();
        return view('user.payment-merchants.index', compact('payment_merchants', 'client_contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'c_contact_key' => 'required|exists:client_contacts,special_key',
                'c_company_key' => 'required|exists:client_companies,special_key',
                'name' => 'required|string|max:255',
                'descriptor' => 'nullable|string|max:255',
                'vendor_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'limit' => 'nullable|integer|min:1',
                'capacity' => 'nullable|integer|min:1',
                'payment_method' => 'required|string|in:authorize,edp,stripe,paypal,bank transfer',
                'environment' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::ENVIRONMENT_SANDBOX, PaymentMerchantConstants::ENVIRONMENT_PRODUCTION]),
                ],
                'status' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::STATUS_ACTIVE, PaymentMerchantConstants::STATUS_INACTIVE, PaymentMerchantConstants::STATUS_SUSPENDED]),
                ],
            ]);
            $data = [
                'c_contact_key' => $validatedData['c_contact_key'],
                'c_company_key' => $validatedData['c_company_key'],
                'name' => $validatedData['name'],
                'descriptor' => $validatedData['descriptor'] ?? null,
                'vendor_name' => $validatedData['vendor_name'] ?? null,
                'email' => $validatedData['email'] ?? null,
                'payment_method' => $validatedData['payment_method'],
                'limit' => $validatedData['limit'] ?? null,
                'capacity' => $validatedData['capacity'] ?? null,
                'environment' => $request->environment ?? null,
                'status' => $validatedData['status'],
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
            $client_account = PaymentMerchant::create($data);
            DB::commit();
            $client_account->refresh();
            $client_account->loadMissing('client_contact', 'client_company')->append('current_month_usage');
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
        if ($request->ajax()) {
            if (!$client_account) {
                return response()->json(['error' => 'Record not found!'], 404);
            }
            return response()->json(['client_account' => $client_account]);
        }
        return view('user.payment-merchants.edit', compact('client_account'));
    }

    /**
     * Update the specified payment merchant in storage.
     *
     * @param Request $request
     * @param PaymentMerchant $client_account
     * @return JsonResponse
     */
    public function update(Request $request, PaymentMerchant $client_account): JsonResponse
    {
//        $this->authorize('update', $client_account);
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'c_contact_key' => 'required|exists:client_contacts,special_key',
                'c_company_key' => 'required|exists:client_companies,special_key',
                'name' => 'required|string|max:255',
                'descriptor' => 'nullable|string|max:255',
                'vendor_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'limit' => 'nullable|integer|min:1',
                'capacity' => 'nullable|integer|min:1',
                'payment_method' => 'required|string|in:authorize,edp,stripe,paypal,bank transfer',
                'environment' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::ENVIRONMENT_SANDBOX, PaymentMerchantConstants::ENVIRONMENT_PRODUCTION]),
                ],
                'status' => [
                    'required',
                    Rule::in([PaymentMerchantConstants::STATUS_ACTIVE, PaymentMerchantConstants::STATUS_INACTIVE, PaymentMerchantConstants::STATUS_SUSPENDED]),
                ],
            ]);
            $updateData = [
                'c_contact_key' => $validatedData['c_contact_key'],
                'c_company_key' => $validatedData['c_company_key'],
                'name' => $validatedData['name'],
                'descriptor' => $validatedData['descriptor'] ?? null,
                'vendor_name' => $validatedData['vendor_name'] ?? null,
                'email' => $validatedData['email'] ?? null,
                'payment_method' => $validatedData['payment_method'],
                'limit' => $validatedData['limit'] ?? null,
                'capacity' => $validatedData['capacity'] ?? null,
                'environment' => $request->environment ?? null,
                'status' => $validatedData['status'],
            ];
            $client_account->update($updateData);
            DB::commit();
            $client_account->refresh();
            $client_account->loadMissing('client_contact', 'client_company')->append('current_month_usage');
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
     * Showing accounts of specified resource.
     */
    public function by_brand($brand_key)
    {
        if (!$brand_key) {
            return response()->json(['error' => 'Oops! Brand not found.'], 404);
        }
        $teams = auth()->user()->teams()->with('brands')->get();
        $brands = $teams->flatMap(function ($team) {
            return $team->brands;
        });
        if (!$brands->contains('brand_key', $brand_key)) {
            return response()->json(['error' => 'Oops! Brand not found.'], 404);
        }
        $brand = Brand::where('brand_key', $brand_key)->first();
        if (!$brand) {
            return response()->json(['error' => 'Oops! Brand not found.'], 404);
        }
        $brand->load('client_accounts');
        $client_accounts = $brand->client_accounts;
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
}
