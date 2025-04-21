<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
        $brands = Brand::where('status', 1)->get();
        $teams = Team::where('status', 1)->get();
        $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
        $leads = Lead::with('customer_contact')->get();
        return view('admin.leads.index', compact('leads', 'brands', 'teams', 'customer_contacts'));
    }

    /**
     * Show the form for creating a new lead.
     */
    public function create()
    {
//        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->get());
//        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->get());
        $teams = Team::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
        return view('admin.leads.create', compact('brands', 'teams', 'customer_contacts'));
    }

    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'brand_key' => 'required|integer|exists:brands,brand_key',
                'team_key' => 'nullable|integer|exists:teams,team_key',
                'lead_status_id' => 'required|integer|exists:lead_statuses,id',
                'name' => 'required||string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string',
                'note' => 'nullable|string',
                'phone' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20'
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
                'name.required' => 'The client name is required for fresh clients.',
                'name.string' => 'The client name must be a valid string.',
                'name.max' => 'The client name cannot exceed 255 characters.',
                'email.required' => 'The client email is required for fresh clients.',
                'email.email' => 'The client email must be a valid email address.',
                'email.max' => 'The client email cannot exceed 255 characters.',
                'email.unique' => 'This email is already in use.',
                'phone.required' => 'The client phone number is required for fresh clients.',
                'phone.string' => 'The client phone number must be a valid string.',
                'phone.max' => 'The client phone number cannot exceed 15 characters.',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $customer_contact = CustomerContact::firstOrCreate(
                ['email' => $request->input('email')],
                [
                    'brand_key' => $request->input('brand_key'),
                    'team_key' => $request->input('team_key'),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'country' => $request->input('country'),
                    'zipcode' => $request->input('zipcode'),
                    'ip_address' => $request->input('ip_address'),
                ]
            );
            if (!$customer_contact) {
                return response()->json(['errors' => 'The Customer key does not exist.']);
            }
            $lead = Lead::create([
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
                'cus_contact_key' => $customer_contact->special_key,
                'lead_status_id' => $request->input('lead_status_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country'),
                'zipcode' => $request->input('zipcode'),
//                'ip_address' => $request->input('ip_address'),
                'note' => $request->input('note'),
            ]);
            DB::commit();
            $lead->refresh();
            $lead->loadMissing('customer_contact','brand','team','leadStatus');
            if ($lead->created_at->isToday()) {
                $date = "Today at " . $lead->created_at->timezone('GMT+5')->format('g:i A') . "GMT + 5";
            } else {
                $date = $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') . "GMT + 5";
            }
            $lead->date = $date;
            return response()->json(['data' => $lead, 'success' => 'Record created successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating the record', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified lead.
     */
    public function show(Lead $lead)
    {
        return response()->json(['lead' => $lead]);
//        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit(Lead $lead)
    {
        //$brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->get());
        //$teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->get());
        $brands = Brand::where('status', 1)->get();
        $teams = Team::where('status', 1)->get();
        $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
        return response()->json(['lead' => $lead, 'brands' => $brands, 'teams' => $teams, 'customer_contacts' => $customer_contacts]);
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'brand_key' => 'nullable|integer',
                'team_key' => 'nullable|integer',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'zipcode' => 'nullable|string|max:10',
                'note' => 'nullable|string',
                'status' => 'required|in:0,1',
                'phone' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $customer_contact = CustomerContact::firstOrCreate(
                ['email' => $request->input('email')],
                [
                    'brand_key' => $request->input('brand_key'),
                    'team_key' => $request->input('team_key'),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'country' => $request->input('country'),
                    'zipcode' => $request->input('zipcode'),
                    'ip_address' => $request->input('ip_address'),
                ]
            );
            if (!$customer_contact) {
                return response()->json(['errors' => 'The Customer key does not exist.']);
            }
            $lead->update([
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
//                'cus_contact_key' => $customer_contact->special_key,
                'lead_status_id' => $request->input('lead_status_id'),
                'name' => $request->input('name'),
//                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'country' => $request->input('country'),
                'zipcode' => $request->input('zipcode'),
//                'ip_address' => $request->input('ip_address'),
                'note' => $request->input('note'),
                'status' => $request->input('status'),
            ]);
            DB::commit();
            $lead->loadMissing('customer_contact','brand','team','leadStatus');
            if ($lead->created_at->isToday()) {
                $date = "Today at " . $lead->created_at->timezone('GMT+5')->format('g:i A') . "GMT + 5";
            } else {
                $date = $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') . "GMT + 5";
            }
            $lead->date = $date;
            return response()->json(['data' => $lead, 'success' => 'Record created successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating the record', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Lead $lead)
    {
        try {
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
