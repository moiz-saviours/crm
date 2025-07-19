<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ClientContact;
use App\Models\CustomerContact;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMerchant;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $agents = User::where('status', 1)->orderBy('name')->get();
//        $all_payments = Payment::where('status', 1)->get();
        $payments = Payment::with(['brand', 'team', 'agent'])->orderBy('payment_date')->get();
        $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
        $client_contacts = ClientContact::select('id', 'special_key', 'name')
            ->with([
                'companies:id,special_key,c_contact_key,name',
                'companies.client_accounts:id,c_contact_key,c_company_key,name,payment_method',
            ])
            ->orderBy('name')
            ->get()
            ->toArray();
        $unpaid_invoices = Invoice::where('status', 0)->orderBy('created_at', 'desc')->get();
        return view('admin.payments.index', compact('unpaid_invoices', 'payments', 'brands', 'teams', 'agents', 'customer_contacts', 'client_contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $agents = User::where('status', 1)->orderBy('name')->get();
        $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
        return view('admin.payments.create', compact('brands', 'teams', 'agents', 'customer_contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_account' => 'required|integer|exists:payment_merchants,id',
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'required|integer|exists:teams,team_key',
            'agent_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'description' => 'nullable|string|max:500',
            'type' => 'required|integer|in:0,1',
            'transaction_id' => 'required|string|max:255',
            'cus_contact_key' => 'required_if:type,1|nullable|integer|exists:customer_contacts,special_key',
            'customer_contact_name' => 'required_if:type,0|nullable|string|max:255',
            'customer_contact_email' => 'required_if:type,0|nullable|email|max:255',
            'customer_contact_phone' => 'required_if:type,0|nullable|string|max:15',
//            'payment_method' => 'required|string|in:authorize,edp,stripe,credit card,bank transfer,paypal,cash,other',
            'payment_date' => 'required|date',
            'invoice_key' => 'nullable|string|max:255',
        ], [
            'client_account.required' => 'The client account field is required.',
            'client_account.integer' => 'The client account must be a valid integer.',
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'agent_id.required' => 'The agent field is required.',
            'agent_id.integer' => 'The agent must be a valid integer.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 500 characters.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 1.00',
            'amount.max' => 'The amount may not be greater than ' . config('invoice.max_amount') . '.',
            'transaction_id.required' => 'The transaction ID is required.',
            'cus_contact_key.integer' => 'The customer contact key must be a valid integer.',
            'cus_contact_key.exists' => 'The selected customer contact does not exist.',
            'cus_contact_key.required_if' => 'The customer contact key field is required when type is upsale.',
            'customer_contact_name.required_if' => 'The customer contact name is required for fresh customers.',
            'customer_contact_name.string' => 'The customer contact name must be a valid string.',
            'customer_contact_name.max' => 'The customer contact name cannot exceed 255 characters.',
            'customer_contact_email.required_if' => 'The customer contact email is required for fresh customers.',
            'customer_contact_email.email' => 'The customer contact email must be a valid email address.',
            'customer_contact_email.max' => 'The customer contact email cannot exceed 255 characters.',
            'customer_contact_email.unique' => 'This email is already in use.',
            'customer_contact_phone.required_if' => 'The customer contact phone number is required for fresh customers.',
            'customer_contact_phone.string' => 'The customer contact phone number must be a valid string.',
            'customer_contact_phone.max' => 'The customer contact phone number cannot exceed 15 characters.',
            'type.required' => 'The invoice type is required.',
            'type.in' => 'The type field must be fresh or upsale.',
        ]);
        $payment = Payment::select('id', 'invoice_key', 'brand_key', 'team_key', 'agent_id', 'merchant_id', 'cus_contact_key', 'transaction_id', 'payment_method', 'amount', 'status', 'payment_date', 'created_at')->with(['invoice:invoice_key,invoice_number', 'brand:brand_key,name', 'team:team_key,name', 'agent:id,name', 'customer_contact:special_key,name', 'payment_gateway:id,name,payment_method,descriptor'])->where('invoice_key', 940367211)->first();
        $payment->date = "Today at " . $payment->created_at->timezone('GMT+5')->format('g:i A') . "GMT + 5";
        $unpaid_invoices = Invoice::select(['invoice_key', 'invoice_number', 'brand_key', 'team_key', 'agent_id', 'cus_contact_key', 'currency', 'total_amount', 'created_at',])->with(['customer_contact:special_key,name'])->where('status', 0)->orderBy('created_at', 'desc')->get()->map(function ($invoice) {
            $invoice->formatted_date = $invoice->created_at->format('jS F Y');
            return $invoice;
        });
        return response()->json(['data' => $payment, 'unpaid_invoices' => $unpaid_invoices,
            'success' => 'Record created successfully!']);
        $validator->after(function ($validator) use ($request) {
            if ($request->filled('invoice_key')) {
                $invoice = Invoice::where('invoice_key', $request->invoice_key)->first();
                if (!$invoice) {
                    $validator->errors()->add('invoice_key', 'The selected invoice does not exist.');
                } elseif ($invoice->status != 0) {
                    $statusLabel = match ($invoice->status) {
                        1 => 'Paid',
                        2 => 'Refunded',
                        3 => 'Chargeback',
                        default => 'Unknown',
                    };
                    $validator->errors()->add('invoice_key', "This invoice is not unpaid. Status: {$statusLabel}");
                }
            }
        });
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
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
            $account = PaymentMerchant::where('id', $request->input('client_account'))->first();
            if (!$account->exists()) {
                return response()->json(['error' => 'The selected client account does not exist. Please select a different or create a new one.'], 404);
            }
            if ($request->filled('invoice_key')) {
                $invoice = Invoice::where('invoice_key', $request->invoice_key)->where('status', 0)->first();
                if (empty($invoice->brand_key)) {
                    $invoice->brand_key = $request->input('brand_key');
                }
                if (empty($invoice->team_key)) {
                    $invoice->team_key = $request->input('team_key');
                }
                if (empty($invoice->cus_contact_key)) {
                    $invoice->cus_contact_key = $customer_contact->special_key;
                }
                if (empty($invoice->agent_id)) {
                    $invoice->agent_id = $request->input('agent_id');
                    $invoice->agent_type = 'App\Models\User';
                }
                $invoice->status = 1;
                $invoice->save();
                if (!$invoice) {
                    return response()->json(['error' => 'The selected invoice does not exist.'], 404);
                }
            } else {
                $invoiceData = [
                    'brand_key' => $request->input('brand_key'),
                    'team_key' => $request->input('team_key'),
                    'cus_contact_key' => $customer_contact->special_key,
                    'description' => $request->description,
                    'amount' => $request->amount,
                    'total_amount' => $request->input('amount'),
                    'type' => $request->input('type'),
                    'status' => 1,
                ];
                if ($request->has('agent_id')) {
                    $invoiceData['agent_id'] = $request->input('agent_id');
                    $invoiceData['agent_type'] = 'App\Models\User';
                }
                $invoice = Invoice::create($invoiceData);
            }
            $paymentData = [
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
                'cus_contact_key' => $customer_contact->special_key,
                'invoice_key' => $invoice->invoice_key,
                'invoice_number' => $invoice->invoice_number,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_type' => $request->input('type'),
                'merchant_id' => $account->id,
                'payment_method' => $account->payment_method,
                'payment_date' => $request->input('payment_date'),
            ];
            if ($request->has('agent_id')) {
                $paymentData['agent_id'] = $request->input('agent_id');
                $paymentData['agent_type'] = 'App\Models\User';
            }
            $payment = Payment::create($paymentData);
            DB::commit();
            $payment = Payment::select('id', 'invoice_key', 'brand_key', 'team_key', 'agent_id', 'agent_type', 'merchant_id', 'cus_contact_key', 'transaction_id', 'payment_method', 'amount', 'status', 'payment_date', 'created_at')->findOrFail($payment->id);
            $payment->date = "Today at " . $payment->created_at->timezone('GMT+5')->format('g:i A') . "GMT + 5";
            $unpaid_invoices = Invoice::select(['invoice_key', 'invoice_number', 'brand_key', 'team_key', 'agent_id', 'cus_contact_key', 'currency', 'total_amount', 'created_at',])->with(['customer_contact:special_key,name'])->where('status', 0)->orderBy('created_at', 'desc')->get()->map(function ($invoice) {
                $invoice->formatted_date = $invoice->created_at->format('jS F Y');
                return $invoice;
            });
            return response()->json(['data' => $payment, 'unpaid_invoices' => $unpaid_invoices,
                'success' => 'Record created successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating the record', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        try {
            return response()->json(['error' => 'Harmful Behaviour Detected!.']);
            if (!$payment->exists) {
                if (request()->ajax()) {
                    return response()->json(['error' => 'Oops! Record not found.']);
                }
                return redirect()->route('admin.payment.index')->with('error', 'Record not found.');
            }
            //$brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
            //$teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
            $brands = Brand::where('status', 1)->orderBy('name')->get();
            $teams = Team::where('status', 1)->orderBy('name')->get();
            $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
            $users = User::where('status', 1)->orderBy('name')->get();
            $payment->loadMissing('customer_contact');
            return response()->json(['payment' => $payment, 'brands' => $brands, 'teams' => $teams, 'customer_contacts' => $customer_contacts, 'users' => $users]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
            }
            return redirect()->route('admin.payment.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        return response()->json(['error' => 'Harmful Behaviour Detected!.']);
        $validator = Validator::make($request->all(), [
            'client_account' => 'required|integer|exists:payment_merchants,id',
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'required|integer|exists:teams,team_key',
            'agent_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'description' => 'nullable|string|max:500',
            'type' => 'required|integer|in:0,1', /** 0 = fresh, 1 = upsale */
            'transaction_id' => 'required|string|max:255',
            'cus_contact_key' => 'required_if:type,1|nullable|integer|exists:customer_contacts,special_key',
            'customer_contact_name' => 'required_if:type,0|nullable|string|max:255',
            'customer_contact_email' => 'required_if:type,0|nullable|email|max:255|unique:customer_contacts,email,' . $payment->cus_contact_key . ',special_key',
            'customer_contact_phone' => 'required_if:type,0|nullable|string|max:15',
//            'payment_method' => 'required|string|in:authorize,edp,stripe,credit card,bank transfer,paypal,cash,other',
            'payment_date' => 'required|date',
        ], [
            'client_account.required' => 'The client account field is required.',
            'client_account.integer' => 'The client account must be a valid integer.',
            'brand_key.required' => 'The brand field is required.',
            'team_key.required' => 'The team field is required.',
            'agent_id.required' => 'The agent field is required.',
            'amount.required' => 'The amount field is required.',
            'payment_type.required' => 'The payment type is required.',
            'transaction_id.max' => 'The transaction ID may not be greater than 255 characters.',
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
            'type.required' => 'The invoice type is required.',
            'type.in' => 'The type field must be fresh or upsale.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {

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
            $invoice = Invoice::where('invoice_key', $payment->invoice_key)->first();
            if (!$invoice || !$invoice->invoice_key) {
                return response()->json(['error' => 'Oops! The invoice does not exist.']);
            }
            $account = PaymentMerchant::where('id', $request->input('client_account'))->first();
            if (!$account->exists()) {
                return response()->json(['error' => 'The selected client account does not exist. Please select a different or create a new one.'], 404);
            }
            $invoice->update([
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
                'cus_contact_key' => $customer_contact->special_key,
                'agent_id' => $request->input('agent_id'),
                'description' => $request->input('description'),
                'amount' => $request->input('amount'),
                'total_amount' => $request->input('amount'),
                'type' => $request->input('type'),
            ]);
            $payment->update([
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
                'cus_contact_key' => $customer_contact->special_key,
                'agent_id' => $request->agent_id,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_type' => $request->input('type'),
                'merchant_id' => $account->id,
                'payment_method' => $account->payment_method,
                'payment_date' => $request->input('payment_date'),
            ]);
            DB::commit();
            $payment->loadMissing('invoice', 'customer_contact', 'brand', 'team', 'agent');
            if ($payment->created_at->isToday()) {
                $date = "Today at " . $payment->created_at->timezone('GMT+5')->format('g:i A') . "GMT + 5";
            } else {
                $date = $payment->created_at->timezone('GMT+5')->format('M d, Y g:i A') . "GMT + 5";
            }
            $payment->date = $date;
            return response()->json(['data' => $payment, 'success' => 'Record updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating the record', 'message' => $e->getMessage()], 500);
        }
    }
}
