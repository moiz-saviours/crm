<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\Invoice;
use App\Models\InvoiceMerchant;
use App\Models\PaymentMerchant;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index()
    {
        $invoices = Invoice::all();
        $brands = Brand::where('status', 1)->get();
        $groupedMerchants = [];
        foreach ($brands as $brand) {
            $client_accounts = $brand->client_accounts;
            $groupedMerchants[$brand->brand_key] = $client_accounts
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
        }
        $teams = Team::where('status', 1)->get();
        $customer_contacts = CustomerContact::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        return view('admin.invoices.index', compact('invoices', 'groupedMerchants', 'brands', 'teams', 'customer_contacts', 'users'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->get());
        $customer_contacts = CustomerContact::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        return view('admin.invoices.create', compact('brands', 'teams', 'customer_contacts', 'users'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchants' => ['nullable', 'array'],
            'merchants.*' => ['required', 'numeric'],
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'cus_contact_key' => 'required_if:type,1|nullable|integer|exists:customer_contacts,special_key',
            'customer_contact_name' => 'required_if:type,0|nullable|string|max:255',
            'customer_contact_email' => 'required_if:type,0|nullable|email|max:255',
            'customer_contact_phone' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 0) {
                        if (empty($value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field is required when type is Fresh.");
                        }

                        if (!preg_match('/^(\+?\d{1,3}[-.\s]?)?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/', $value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field format is invalid.");
                        }

                        if (strlen($value) < 8) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must be at least 8 characters.");
                        }

                        if (strlen($value) > 20) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must not be greater than 20 characters.");
                        }
                    }
                },
            ],
            'agent_id' => 'nullable|integer',
//            'agent_type' => 'required|string|in:admins,users',
            'description' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'taxable' => 'nullable|boolean',
            'tax_type' => 'nullable|in:none,percentage,fixed',
            'tax_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|in:USD,GBP,AUD,CAD',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'type' => 'required|integer|in:0,1', /** 0 = fresh, 1 = upsale */
            'due_date' => 'required|date|after_or_equal:' . now('Pacific/Honolulu')->format('Y-m-d') . '|before_or_equal:' . now('Pacific/Honolulu')->addYear()->format('Y-m-d'),
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'The selected brand does not exist.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'The selected team does not exist.',
            'cus_contact_key.integer' => 'The customer contact key must be a valid integer.',
            'cus_contact_key.exists' => 'The selected customer contact does not exist.',
            'cus_contact_key.required_if' => 'The customer contact key field is required when type is upsale.',
            'customer_contact_name.required_if' => 'The customer name is required for fresh customers.',
            'customer_contact_name.string' => 'The customer contact name must be a valid string.',
            'customer_contact_name.max' => 'The customer contact name cannot exceed 255 characters.',
            'customer_contact_email.required_if' => 'The customer contact email is required for fresh customers.',
            'customer_contact_email.email' => 'The customer contact email must be a valid email address.',
            'customer_contact_email.max' => 'The customer contact email cannot exceed 255 characters.',
            'customer_contact_email.unique' => 'This email is already in use.',
            'customer_contact_phone.required_if' => 'The customer contact phone number is required for fresh customers.',
            'customer_contact_phone.string' => 'The customer contact phone number must be a valid string.',
            'customer_contact_phone.max' => 'The customer contact phone number cannot exceed 15 characters.',

            'agent_id.required' => 'The agent field is required.',
            'agent_id.integer' => 'The agent must be a valid integer.',
//            'agent_type.required' => 'The agent type field is required.',
//            'agent_type.in' => 'The agent type must be either "admins" or "users".',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 500 characters.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 1.00',
            'amount.max' => 'The amount may not be greater than ' . config('invoice.max_amount') . '.',
            'type.required' => 'The invoice type is required.',
            'type.in' => 'The type field must be fresh or upsale.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $brand = Brand::where('brand_key', $request->input('brand_key'))->first();
            if (!$brand) {
                return response()->json(['error' => 'Brand not found.'], 404);
            }
            $customer_contact = $request->input('type') == 0
                ? CustomerContact::firstOrCreate(
                    ['email' => $request->input('customer_contact_email')],
                    [
                        'brand_key' => $request->input('brand_key'),
                        'team_key' => $request->input('team_key'),
                        'name' => $request->input('customer_contact_name'),
                        'phone' => $request->input('customer_contact_phone'),
                    ]
                )
                : CustomerContact::where('special_key', $request->input('cus_contact_key'))->first();
            if (!$customer_contact) {
                return response()->json(['error' => 'The selected customer contact does not exist.'], 404);
            }
            if (!$customer_contact->special_key) {
                return response()->json(['error' => 'The selected customer contact does not exist. Please select a different or create a new one.'], 404);
            }
            $taxable = $request->input('taxable', false);
            $tax_type = $request->input('tax_type', 'none');
            $tax_value = $request->input('tax_value', 0);
            $tax_amount = $request->input('tax_amount', 0);
            $amount = $request->input('amount');
            $total_amount = $amount;
            if ($taxable) {
                if ($tax_type == 'percentage' && $tax_value > 0) {
                    $calculated_tax_amount = ($amount * $tax_value) / 100;
                    if ($tax_amount > 0 && $tax_amount != $calculated_tax_amount) {
                        return response()->json(['error' => 'The provided tax amount does not match the calculated percentage tax.'], 400);
                    }
                } elseif ($tax_type == 'fixed' && $tax_value > 0) {
                    if ($tax_amount > 0 && $tax_amount != $tax_value) {
                        return response()->json(['error' => 'The provided tax amount does not match the fixed tax value.'], 400);
                    }
                } elseif ($tax_type == 'none') {
                    if ($tax_amount > 0) {
                        return response()->json(['error' => 'Tax amount should be 0 when tax type is none.'], 400);
                    }
                }
            }
            if ($taxable) {
                $total_amount = $amount + $tax_amount;
            }
            $data = [
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
                'cus_contact_key' => $customer_contact->special_key,
                'description' => $request->input('description'),
                'amount' => $request->input('amount'),
                'taxable' => $taxable,
                'tax_type' => $tax_type,
                'tax_value' => $tax_value,
                'tax_amount' => $tax_amount,
                'total_amount' => $total_amount,
                'currency' => $request->input('currency', 'USD'),
                'due_date' => $request->input('due_date'),
                'type' => $request->input('type'),
                'status' => 0,
            ];
            if ($request->has('agent_id')) {
                $data['agent_id'] = $request->input('agent_id');
                $data['agent_type'] = 'App\Models\User';
            }
            //TODO
//            else {
//                if (!auth()->check()) {
//                    return response()->json(['error' => 'Authentication required to create an invoice'], 401);
//                }
//                $data['agent_id'] = auth()->id();
//                $data['agent_type'] = get_class(auth()->user());
//            }
            $invoice = Invoice::create($data);
            $brand->load(['client_accounts' => fn($q) => $q->whereIn('payment_method', ['authorize', 'edp'])]);
            $client_accounts = $brand->client_accounts;
            $validMerchantIds = $client_accounts->pluck('id')->toArray();
            $merchantExcluded = [];

            if ($request->has('merchants')) {
                $merchants = $request->get('merchants', []);
                if (array_diff($merchants, $validMerchantIds)) {
                    return response()->json(['error' => 'One or more merchants are not authorized.'], 403);
                }
                foreach ($merchants as $type => $merchant_id) {
                    $client_account = $client_accounts->firstWhere('id', $merchant_id);
                    if (!$client_account || !$client_account->hasSufficientLimitAndCapacity($client_account->id,$invoice->total_amount)->exists()) {
                        $merchantExcluded[] = $client_account ? $client_account->payment_method . " " . $client_account->name : "Unknown Merchant";
                    } else {
                        InvoiceMerchant::create([
                            'invoice_key' => $invoice->invoice_key,
                            'merchant_type' => $type,
                            'merchant_id' => $merchant_id,
                        ]);
                    }
                }
            }
            DB::commit();
            $invoice->refresh();
            $invoice->loadMissing('customer_contact', 'brand', 'team', 'agent');
            $invoice->date = "Today at " . $invoice->created_at->timezone('GMT+5')->format('g:i A') . "GMT + 5";
            $invoice->due_date = Carbon::parse($invoice->due_date)->format('Y-m-d');
            return response()->json(['data' => $invoice, 'success' => "Record created successfully!" .
                (!empty($merchantExcluded)
                    ? " However, the following merchants were excluded due to insufficient limits: " . implode(', ', $merchantExcluded)
                    : "")]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating the record', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        if (!$invoice->id) return response()->json(['error' => 'Invoice does not exist.']);
        $brands = Brand::where('status', 1)->get();
        $teams = Team::where('status', 1)->get();
        $customer_contacts = CustomerContact::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        $invoice->loadMissing('customer_contact', 'invoice_merchants');
        $invoiceMerchants = [];
        foreach ($invoice->invoice_merchants as $merchant) {
            $invoiceMerchants[$merchant->merchant_type] = $merchant->merchant_id;
        }
        $invoice->merchant_types = $invoiceMerchants;
        return response()->json(['invoice' => $invoice, 'brands' => $brands, 'teams' => $teams, 'customer_contacts' => $customer_contacts, 'users' => $users]);
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status == 1) {
            return response()->json(['error' => 'Oops! The Invoice is already paid.'], 400);
        }
        $validator = Validator::make($request->all(), [
            'merchants' => ['nullable', 'array'],
            'merchants.*' => ['required', 'numeric'],
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'cus_contact_key' => 'required_if:type,1|nullable|integer|exists:customer_contacts,special_key',
            'customer_contact_name' => 'required_if:type,0|nullable|string|max:255',
            'customer_contact_email' => 'required_if:type,0|nullable|email|max:255',
            'customer_contact_phone' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 0) {
                        if (empty($value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field is required when type is Fresh.");
                        }

                        if (!preg_match('/^(\+?\d{1,3}[-.\s]?)?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/', $value)) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " field format is invalid.");
                        }

                        if (strlen($value) < 8) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must be at least 8 characters.");
                        }

                        if (strlen($value) > 20) {
                            $fail("The " . ucwords(str_replace("_", " ", $attribute)) . " must not be greater than 20 characters.");
                        }
                    }
                },
            ],
            'agent_id' => 'nullable|integer',
//            'agent_type' => 'required|string|in:admins,users',
            'description' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'taxable' => 'nullable|boolean',
            'tax_type' => 'nullable|in:none,percentage,fixed',
            'tax_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|in:USD,GBP,AUD,CAD',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'type' => 'required|integer|in:0,1', /** 0 = fresh, 1 = upsale */
            'due_date' => 'required|date|after_or_equal:' . now('Pacific/Honolulu')->format('Y-m-d') . '|before_or_equal:' . now('Pacific/Honolulu')->addYear()->format('Y-m-d'),
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'The selected brand does not exist.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'The selected team does not exist.',
            'cus_contact_key.integer' => 'The customer contact key must be a valid integer.',
            'cus_contact_key.exists' => 'The selected customer contact does not exist.',
            'cus_contact_key.required_if' => 'The customer contact key field is required when type is upsale.',
            'customer_contact_name.required_if' => 'The customer name is required for fresh customers.',
            'customer_contact_name.string' => 'The customer contact name must be a valid string.',
            'customer_contact_name.max' => 'The customer contact name cannot exceed 255 characters.',
            'customer_contact_email.required_if' => 'The customer contact email is required for fresh customers.',
            'customer_contact_email.email' => 'The customer contact email must be a valid email address.',
            'customer_contact_email.max' => 'The customer contact email cannot exceed 255 characters.',
            'customer_contact_email.unique' => 'This email is already in use.',
            'customer_contact_phone.required_if' => 'The customer contact phone number is required for fresh customers.',
            'customer_contact_phone.string' => 'The customer contact phone number must be a valid string.',
            'customer_contact_phone.max' => 'The customer contact phone number cannot exceed 15 characters.',
            'agent_id.required' => 'The agent field is required.',
            'agent_id.integer' => 'The agent must be a valid integer.',
//            'agent_type.required' => 'The agent type field is required.',
//            'agent_type.in' => 'The agent type must be either "admins" or "users".',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 500 characters.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 1.00',
            'amount.max' => 'The amount may not be greater than ' . config('invoice.max_amount') . '.',
            'type.required' => 'The invoice type is required.',
            'type.in' => 'The type field must be fresh or upsale.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $brand = Brand::where('brand_key', $request->input('brand_key'))->first();
            if (!$brand) {
                return response()->json(['error' => 'Brand not found.'], 404);
            }
            $customer_contact = $request->input('type') == 0
                ? CustomerContact::firstOrCreate(
                    ['email' => $request->input('customer_contact_email')],
                    [
                        'brand_key' => $request->input('brand_key'),
                        'team_key' => $request->input('team_key'),
                        'name' => $request->input('customer_contact_name'),
                        'phone' => $request->input('customer_contact_phone'),
                    ]
                )
                : CustomerContact::where('special_key', $request->input('cus_contact_key'))->first();
            if (!$customer_contact || !$customer_contact->special_key) {
                return response()->json(['error' => 'The selected customer contact does not exist.']);
            }
            $taxable = $request->input('taxable', false);
            $tax_type = $request->input('tax_type', 'none');
            $tax_value = $request->input('tax_value', 0);
            $tax_amount = $request->input('tax_amount', 0);
            $amount = $request->input('amount');
            $total_amount = $amount;
            if ($taxable) {
                if ($tax_type == 'percentage' && $tax_value > 0) {
                    $calculated_tax_amount = ($amount * $tax_value) / 100;
                    if ($tax_amount > 0 && $tax_amount != $calculated_tax_amount) {
                        return response()->json(['error' => 'The provided tax amount does not match the calculated percentage tax.'], 400);
                    }
                } elseif ($tax_type == 'fixed' && $tax_value > 0) {
                    if ($tax_amount > 0 && $tax_amount != $tax_value) {
                        return response()->json(['error' => 'The provided tax amount does not match the fixed tax value.'], 400);
                    }
                } elseif ($tax_type == 'none') {
                    if ($tax_amount > 0) {
                        return response()->json(['error' => 'Tax amount should be 0 when tax type is none.'], 400);
                    }
                }
            }
            if ($taxable) {
                $total_amount = $amount + $tax_amount;
            }
            $invoice->update([
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
                'cus_contact_key' => $customer_contact->special_key,
                'agent_id' => $request->input('agent_id'),
                'description' => $request->input('description'),
                'amount' => $request->input('amount'),
                'taxable' => $taxable,
                'tax_type' => $tax_type,
                'tax_value' => $tax_value,
                'tax_amount' => $tax_amount,
                'total_amount' => $total_amount,
                'type' => $request->input('type'),
                'due_date' => $request->input('due_date'),
            ]);
            $brand->load(['client_accounts' => fn($q) => $q->whereIn('payment_method', ['authorize', 'edp'])]);
            $client_accounts = $brand->client_accounts->unique('id');
            $validMerchantIds = $client_accounts->pluck('id')->toArray();
            $existingMerchants = InvoiceMerchant::where('invoice_key', $invoice->invoice_key)
                ->pluck('merchant_id', 'merchant_type')
                ->toArray();
            $newMerchants = [];
            $merchants = $request->get('merchants', []);
            if (array_diff($merchants, $validMerchantIds)) {
                return response()->json(['error' => 'One or more merchants are not authorized.'], 403);
            }
            foreach ($merchants as $type => $merchant_id) {
                $client_account = $client_accounts->firstWhere('id', $merchant_id);
                if (!$client_account || !$client_account->hasSufficientLimitAndCapacity($client_account->id,$invoice->total_amount)->exists()) {
                    $merchantExcluded[$type] = $client_account ? $client_account->payment_method . " " . $client_account->name : "Unknown Merchant";
                    unset($merchants[$type]);
                }
            }
            $merchantsToDelete = array_diff_assoc($existingMerchants, $merchants);
            foreach ($merchants as $type => $merchant_id) {
                if (!isset($existingMerchants[$type]) || $existingMerchants[$type] != $merchant_id) {
                    $newMerchants[] = [
                        'invoice_key' => $invoice->invoice_key,
                        'merchant_type' => $type,
                        'merchant_id' => $merchant_id,
                    ];
                }
            }
            if (!empty($merchantsToDelete)) {
                InvoiceMerchant::where('invoice_key', $invoice->invoice_key)
                    ->whereIn('merchant_type', array_keys($merchantsToDelete))
                    ->delete();
            }
            if (!empty($newMerchants)) {
                foreach ($newMerchants as $newMerchant) {
                    InvoiceMerchant::create([
                        'invoice_key' => $newMerchant['invoice_key'],
                        'merchant_type' => $newMerchant['merchant_type'],
                        'merchant_id' => $newMerchant['merchant_id'],
                    ]);
                }
            }
            DB::commit();
            $invoice->loadMissing('customer_contact', 'brand', 'team', 'agent');
            if ($invoice->created_at->isToday()) {
                $date = "Today at " . $invoice->created_at->timezone('GMT+5')->format('g:i A') . "GMT + 5";
            } else {
                $date = $invoice->created_at->timezone('GMT+5')->format('M d, Y g:i A') . "GMT + 5";
            }
            $invoice->date = $date;
            $message = "Record updated successfully!";
            if (!empty($merchantExcluded)) {
                $message .= " However, the following merchants were excluded due to insufficient limits: " . implode(', ', $merchantExcluded);
            }
            return response()->json(['data' => $invoice, 'success' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating the record', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Invoice $invoice)
    {
        try {
            if ($invoice->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'An error occurred while deleting the record.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
