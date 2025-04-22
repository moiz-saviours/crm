<?php

namespace App\Http\Controllers\AdminOld;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\Invoice;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index()
    {
        $invoices = Invoice::where('status', 1)->get();
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $clients = CustomerContact::where('status', 1)->get();
        $users = User::where('status', 1)->orderBy('name')->get();
        return view('admin.invoices.create', compact('brands', 'teams', 'clients', 'users'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'required|integer|exists:teams,team_key',
            'client_key' => 'required_if:type,1|nullable|integer|exists:clients,client_key',
            'client_name' => 'required_if:type,0|nullable|string|max:255',
            'client_email' => 'required_if:type,0|nullable|email|max:255|unique:clients,email',
            'client_phone' => 'required_if:type,0|nullable|string|max:15',
            'agent_id' => 'required|integer',
//            'agent_type' => 'required|string|in:admins,users',
            'description' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'type' => 'required|integer|in:0,1',/** 0 = fresh, 1 = upsale */
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'The selected brand does not exist.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'The selected team does not exist.',
            'client_key.integer' => 'The client must be a valid integer.',
            'client_key.exists' => 'The selected client does not exist.',
            'client_key.required' => 'The client key field is required when type is upsale.',
            'client_name.required' => 'The client name is required for fresh clients.',
            'client_name.string' => 'The client name must be a valid string.',
            'client_name.max' => 'The client name cannot exceed 255 characters.',
            'client_email.required' => 'The client email is required for fresh clients.',
            'client_email.email' => 'The client email must be a valid email address.',
            'client_email.max' => 'The client email cannot exceed 255 characters.',
            'client_email.unique' => 'This email is already in use.',
            'client_phone.required' => 'The client phone number is required for fresh clients.',
            'client_phone.string' => 'The client phone number must be a valid string.',
            'client_phone.max' => 'The client phone number cannot exceed 15 characters.',
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
        $client = $request->input('type') == 0
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
        if (!$client) {
            return redirect()->back()->with('error', 'The selected client does not exist.');
        }

        Invoice::create([
            'brand_key' => $request->input('brand_key'),
            'team_key' => $request->input('team_key'),
            'client_key' => $client->client_key,
            'agent_id' => $request->input('agent_id'),
            'agent_type' => 'App\Models\User',
            'creator_id' => auth()->id(),
            'creator_type' => get_class(auth()->user()),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'type' => $request->input('type'),
            'status' => 0,
            'invoice_key' => Invoice::generateInvoiceKey(),
            'invoice_number' => Invoice::generateInvoiceNumber(),
        ]);
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice created successfully.');
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
        if (!$invoice->id) return redirect()->route('admin.invoice.index')->with('error', 'Record not found.');
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $clients = CustomerContact::where('status', 1)->get();
        $users = User::where('status', 1)->orderBy('name')->get();
        return view('admin.invoices.edit', compact('invoice', 'brands', 'teams', 'clients', 'users'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'required|integer|exists:teams,team_key',
            'client_key' => 'required_if:type,1|nullable|integer|exists:clients,client_key',
            'client_name' => 'required_if:type,0|nullable|string|max:255',
            'client_email' => 'required_if:type,0|nullable|email|max:255|unique:clients,email,' . $invoice->client_key . ',client_key',
            'client_phone' => 'required_if:type,0|nullable|string|max:15',
            'agent_id' => 'required|integer',
//            'agent_type' => 'required|string|in:admins,users',
            'description' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:1|max:' . config('invoice.max_amount'),
            'type' => 'required|integer|in:0,1',/** 0 = fresh, 1 = upsale */
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'The selected brand does not exist.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'The selected team does not exist.',
            'client_key.integer' => 'The client must be a valid integer.',
            'client_key.exists' => 'The selected client does not exist.',
            'client_key.required' => 'The client key field is required when type is upsale.',
            'client_name.required' => 'The client name is required for fresh clients.',
            'client_name.string' => 'The client name must be a valid string.',
            'client_name.max' => 'The client name cannot exceed 255 characters.',
            'client_email.required' => 'The client email is required for fresh clients.',
            'client_email.email' => 'The client email must be a valid email address.',
            'client_email.max' => 'The client email cannot exceed 255 characters.',
            'client_email.unique' => 'This email is already in use.',
            'client_phone.required' => 'The client phone number is required for fresh clients.',
            'client_phone.string' => 'The client phone number must be a valid string.',
            'client_phone.max' => 'The client phone number cannot exceed 15 characters.',
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
        $client = $request->input('type') == 0
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

        if (!$client) {
            return redirect()->back()->with('error', 'The selected client does not exist.');
        }

        $invoice->update([
            'brand_key' => $request->input('brand_key'),
            'team_key' => $request->input('team_key'),
            'client_key' => $client->client_key,
            'agent_id' => $request->input('agent_id'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice updated successfully.');
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
