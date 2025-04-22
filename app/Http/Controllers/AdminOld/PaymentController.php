<?php

namespace App\Http\Controllers\AdminOld;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['brand', 'team', 'agent'])->get();
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $agents = User::where('status', 1)->orderBy('name')->get();
        $clients = CustomerContact::where('status', 1)->get();

        return view('admin.payments.create', compact('brands', 'teams', 'agents', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'required|integer|exists:teams,team_key',
            'agent_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'description' => 'nullable|string|max:500',
            'payment_type' => 'required|in:fresh,upsale',
            'transaction_id' => 'nullable|string|max:255',
            'client_name' => 'required_if:payment_type,fresh|string|max:255|nullable',
            'client_email' => 'required_if:payment_type,fresh|email|max:255|nullable',
            'client_phone' => 'required_if:payment_type,fresh|string|max:20|nullable',
            'client_key' => 'required_if:payment_type,upsale|exists:clients,client_key|nullable',
        ], [
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
            'client_name.required_if' => 'The client name is required for fresh payments.',
            'client_email.required_if' => 'The client email is required for fresh payments.',
            'client_phone.required_if' => 'The client phone is required for fresh payments.',
            'client_key.required_if' => 'The client selection is required for upsale payments.',
        ]);

        DB::beginTransaction();

        try {
            $invoiceData = [
                'brand_key' => $request->brand_key,
                'team_key' => $request->team_key,
                'agent_id' => $request->agent_id,
                'description' => $request->description,
                'amount' => $request->amount,
                'invoice_key' => Invoice::generateInvoiceKey(),
                'invoice_number' => Invoice::generateInvoiceNumber(),
            ];
            $invoice = new Invoice($invoiceData);
            $invoice->save();

            $client = $request->input('payment_type') == 'fresh'
                ? CustomerContact::firstOrCreate(
                    ['email' => $request->input('client_email')],
                    [
                        'brand_key' => $request->input('brand_key'),
                        'team_key' => $request->input('team_key'),
                        'name' => $request->input('client_name'),
                        'phone' => $request->input('client_phone'),
                    ]
                )
                : CustomerContact::where('client_key', $request->input('client_key'))->first();

            $paymentData = [
                'brand_key' => $request->brand_key,
                'team_key' => $request->team_key,
                'client_key' => $client->client_key,
                'agent_id' => $request->agent_id,
                'invoice_key' => $invoice->invoice_key,
                'invoice_number' => $invoice->invoice_number,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_type' => $request->input('payment_type') == 0 ? 0 : 1,
            ];

            Payment::create($paymentData);
            DB::commit();
            return redirect()->route('admin.payment.index')->with('success', 'Payment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
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

        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $agents = User::where('status', 1)->orderBy('name')->get();
        $clients = CustomerContact::where('status', 1)->get();
        return view('admin.payments.edit', compact('payment', 'brands', 'teams', 'agents', 'clients'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'required|integer|exists:teams,team_key',
            'agent_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'description' => 'nullable|string|max:500',
            'payment_type' => 'required|in:fresh,upsale',
            'transaction_id' => 'nullable|string|max:255',
            'client_name' => 'required_if:payment_type,fresh|string|max:255|nullable',
            'client_email' => 'required_if:payment_type,fresh|email|max:255|nullable',
            'client_phone' => 'required_if:payment_type,fresh|string|max:20|nullable',
            'client_key' => 'required_if:payment_type,upsale|exists:clients,client_key|nullable',
        ], [
            'brand_key.required' => 'The brand field is required.',
            'team_key.required' => 'The team field is required.',
            'agent_id.required' => 'The agent field is required.',
            'amount.required' => 'The amount field is required.',
            'payment_type.required' => 'The payment type is required.',
            'transaction_id.max' => 'The transaction ID may not be greater than 255 characters.',
            'client_name.required_if' => 'The client name is required for fresh payments.',
            'client_email.required_if' => 'The client email is required for fresh payments.',
            'client_phone.required_if' => 'The client phone is required for fresh payments.',
            'client_key.required_if' => 'The client selection is required for upsale payments.',
        ]);

        DB::beginTransaction();

        try {
            $invoice = Invoice::where('invoice_key', $payment->invoice_key)->firstOrFail();
            $invoice->update([
                'brand_key' => $request->brand_key,
                'team_key' => $request->team_key,
                'agent_id' => $request->agent_id,
                'description' => $request->description,
                'amount' => $request->amount,
            ]);

            // Handle client update or retrieval
            $client = $request->input('payment_type') == 'fresh'
                ? CustomerContact::firstOrCreate(
                    ['email' => $request->input('client_email')],
                    [
                        'brand_key' => $request->input('brand_key'),
                        'team_key' => $request->input('team_key'),
                        'name' => $request->input('client_name'),
                        'phone' => $request->input('client_phone'),
                    ]
                )
                : CustomerContact::where('client_key', $request->input('client_key'))->firstOrFail();

            // Update the payment record
            $payment->update([
                'brand_key' => $request->brand_key,
                'team_key' => $request->team_key,
                'client_key' => $client->client_key,
                'agent_id' => $request->agent_id,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_type' => $request->input('payment_type') == 'fresh' ? 0 : 1,
            ]);

            DB::commit();
            return redirect()->route('admin.payment.index')->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

}
