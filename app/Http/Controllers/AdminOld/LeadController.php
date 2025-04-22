<?php

namespace App\Http\Controllers\AdminOld;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function __construct()
    {
        view()->share('leadStatuses', LeadStatus::where('status', 1)->get());
    }

    /**
     * Display a listing of the leads.
     */
    public function index()
    {
        $leads = Lead::where('status', 1)->get();
        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new lead.
     */
    public function create()
    {
        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $clients = CustomerContact::where('status', 1)->get();
        return view('admin.leads.create', compact('brands', 'teams', 'clients'));
    }


    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'lead_status_id' => 'required|integer|exists:lead_statuses,id',
            'client_key' => 'required_if:type,1|nullable|integer|exists:clients,client_key',
            'client_name' => 'required_if:type,0|nullable|string|max:255',
            'client_email' => 'required_if:type,0|nullable|email|max:255|unique:clients,email',
            'client_phone' => 'required_if:type,0|nullable|string|max:15',
            'type' => 'required|integer|in:0,1', /** 0 = new, 1 = existing */
            'note' => 'nullable|string',
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'The selected brand does not exist.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'The selected team does not exist.',
            'lead_status_id.required' => 'The lead status field is required.',
            'lead_status_id.integer' => 'The lead status must be a valid integer.',
            'lead_status_id.exists' => 'The selected lead status does not exist.',
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
            'type.required' => 'The invoice type is required.',
            'type.in' => 'The type field must be fresh or upsale.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = $request->input('type') == 0
            ? CustomerContact::firstOrCreate(
                ['email' => $request->input('client_email')],
                [
                    'brand_key' => $request->input('brand_key'),
                    'team_key' => $request->input('team_key'),
                    'name' => $request->input('client_name'),
                    'phone' => $request->input('client_phone'),
                    'address' => $request->input('client_address'),
                    'city' => $request->input('client_city'),
                    'state' => $request->input('client_state'),
                    'country' => $request->input('client_country'),
                    'zipcode' => $request->input('client_zipcode'),
                    'ip_address' => $request->input('ip_address'),
                ]
            )
            : CustomerContact::where('client_key', $request->input('client_key'))->first();

        if (!$client) {
            return redirect()->back()->with('error', 'Please try again later.');
        }

        Lead::create([
            'brand_key' => $request->input('brand_key'),
            'team_key' => $request->input('team_key'),
            'client_key' => $client->client_key,
            'lead_status_id' => $request->input('lead_status_id'),
            'name' => $client->name,
            'email' => $client->email,
            'phone' => $client->phone,
            'address' => $client->address,
            'city' => $client->city,
            'state' => $client->state,
            'country' => $client->country,
            'zipcode' => $client->zipcode,
            'note' => $request->input('note'),
        ]);

        return redirect()->route('admin.lead.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified lead.
     */
    public function show(Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit(Lead $lead)
    {
        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $clients = CustomerContact::where('status', 1)->get();
        return view('admin.leads.edit', compact('lead', 'brands', 'teams', 'clients'));
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $validator = Validator::make($request->all(), [
            'brand_key' => 'nullable|integer',
            'team_key' => 'nullable|integer',
            'client_id' => 'nullable|integer|exists:clients,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:leads,email,' . $lead->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'note' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lead->update($request->all());

        return redirect()->route('admin.lead.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Lead $lead)
    {
        try {
            return response()->json(['success' => 'The record has been deleted successfully.']);
            if ($lead->delete()) {
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
    public function change_lead_status(Request $request, Lead $lead)
    {
        if (!$lead) {
            return response()->json(['error' => 'Please try again later.'], 400);
        }
        $validator = Validator::make($request->all(), [
            'lead_status_id' => 'required|integer|exists:lead_statuses,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $lead->update(['lead_status_id' => $request->query('lead_status_id')]);
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, Lead $lead)
    {
        try {
            $lead->status = $request->query('status');
            $lead->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
