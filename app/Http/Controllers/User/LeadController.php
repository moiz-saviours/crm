<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Team;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teams = $user->teams()->with('brands')->get();
        $brands = $teams->flatMap->brands;
        $all_leads = Lead::whereIn('brand_key', Auth::user()->teams()->with(['brands' => function ($query) {
            $query->where('status', 1);
        }])->get()->pluck('brands.*.brand_key')->flatten())
            ->whereIn('team_key', Auth::user()->teams()->pluck('teams.team_key')->flatten()->unique())
            ->with(['brand', 'customer_contact', 'leadStatus'])->get();
        $lead_statuses = LeadStatus::where('status', 1)->get();
        return view('user.leads.index', compact('all_leads', 'lead_statuses','brands', 'teams'));
    }

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
            $lead->loadMissing('customer_contact:id,special_key,name', 'brand:id,brand_key,name', 'team:id,team_key,name', 'leadStatus:id,name');

            if ($lead->created_at->isToday()) {
                $date = "Today at " . $lead->created_at->timezone('GMT+5')->format('g:i A') . " GMT+5";
            } else {
                $date = $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') . " GMT+5";
            }
            $lead->date = $date;
            return response()->json(['data' => $lead, 'success' => 'Record created successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating the record', 'message' => $e->getMessage()], 500);
        }
    }

    public function edit(Lead $lead)
    {
        $user = Auth::user();
        $teams = $user->teams()->with('brands')->get();
        $brands = $teams->flatMap->brands;

        $brandKeys = $brands->pluck('brand_key');
        $teamKeys = $teams->pluck('team_key');

        $customer_contacts = CustomerContact::where('status', 1)
            ->whereIn('brand_key', $brandKeys)
            ->whereIn('team_key', $teamKeys)
            ->orderBy('name')
            ->get();
        return response()->json(['lead' => $lead, 'brands' => $brands, 'teams' => $teams, 'customer_contacts' => $customer_contacts]);
    }


    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead)
    {
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
            DB::beginTransaction();
            // Get previous status before update
            $oldStatusId = $lead->lead_status_id;
            $customer_contact = CustomerContact::withTrashed()->firstOrNew(
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
            $updateData = [
                'brand_key' => $request->input('brand_key'),
                'team_key' => $request->input('team_key'),
                'lead_status_id' => $request->input('lead_status_id'),
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zipcode' => $request->input('zipcode'),
                'note' => $request->input('note'),
                'status' => $request->input('status'),
            ];
            if (is_null($lead->cus_contact_key) && $customer_contact->special_key) {
                $updateData['cus_contact_key'] = $customer_contact->special_key;
            }
            if (is_null($lead->email) && $request->filled('email')) {
                $updateData['email'] = $request->input('email');
            }
            if ($request->filled('country')) {
                $updateData['country'] = $request->input('country');
            }
            $lead->update($updateData);
            $convertedStatus = LeadStatus::where('name', 'Converted')->first();
            // If old status was "Converted" but new one is different — log the change
            if ($convertedStatus && $oldStatusId == $convertedStatus->id && $lead->lead_status_id != $convertedStatus->id) {
                UserActivity::create([
                    'event_type' => 'converted_status_changed',
                    'visitor_id' => $lead->visitor_id,
                    'event_data' => json_encode([
                        'message' => 'Converted lead status was changed manually.',
                        'lead_name' => $lead->name,
                        'old_status' => 'Converted',
                        'new_status' => $lead->leadStatus->name ?? 'Unknown',
                        'changed_by' => auth()->user()->name ?? 'System',
                    ]),
                ]);
            }
            DB::commit();
            $lead->loadMissing(['customer_contact' => function ($query) {
                $query->withTrashed()->select('id', 'special_key', 'name');
            },
                'brand' => function ($query) {
                    $query->withTrashed()->select('brand_key', 'name');
                },
                'team' => function ($query) {
                    $query->withTrashed()->select('team_key', 'name');
                },
                'leadStatus' => function ($query) {
                    $query->withTrashed()->select('id', 'name');
                }]);
            if ($lead->created_at->isToday()) {
                $date = "Today at " . $lead->created_at->timezone('GMT+5')->format('g:i A') . " GMT+5";
            } else {
                $date = $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') . " GMT+5";
            }
            $lead->date = $date;
            return response()->json(['data' => $lead, 'success' => 'Record updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while creating the record', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_lead_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leadStatusId' => 'required|integer|exists:lead_statuses,id',
            'id' => 'required|integer|exists:leads,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        try {
            $lead = Lead::findOrFail($request->input('id'));
            $lead->update([
                'lead_status_id' => $request->input('leadStatusId')  // Update the lead's status
            ]);
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function convert_to_customer(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);

            // Optional: make sure user has access to this lead
            if ($lead->team_key != auth()->user()->team_key) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to convert this lead.'
                ], 403);
            }

            if (!empty($lead->raw_data)) {
                $this->updateLeadFromRawData($lead);
            }

            if (empty($lead->email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid email address found in lead data. Cannot convert to customer.'
                ], 404);
            }

            $existingContact = CustomerContact::where('email', $lead->email)->first();
            if ($existingContact) {
                $customer_contact = $existingContact;
            } else {
                $deviceInfo = json_decode($lead->device_info, true);
                $customer_contact = new CustomerContact([
                    'brand_key' => $lead->brand_key,
                    'team_key' => $lead->team_key, // user side: assign same team
                    'name' => $lead->name,
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'address' => $lead->address,
                    'city' => $lead->city,
                    'state' => $lead->state,
                    'country' => $lead->country,
                    'zipcode' => $lead->zipcode,
                    'ip_address' => $deviceInfo['ip'] ?? null,
                ]);
                $customer_contact->save();
            }

            $lead_status = LeadStatus::where('name', 'Converted')->first();
            $lead_data = [
                'cus_contact_key' => $customer_contact->special_key,
            ];

            if ($lead_status && $lead_status->id) {
                $lead_data['lead_status_id'] = $lead_status->id;
            }

            $lead->update($lead_data);
            $lead->load('customer_contact:id,special_key,name', 'leadStatus:id,name', 'brand:brand_key,name');

            UserActivity::create([
                'event_type' => 'conversion',
                'visitor_id' => $lead->visitor_id,
                'event_data' => json_encode([
                    'message' => $existingContact
                        ? "Lead attached to existing customer"
                        : "Lead converted to new customer",
                    'customer_name' => $customer_contact->name,
                    'customer_email' => $customer_contact->email,
                    'converted_by' => auth()->user()->name ?? 'User',
                ]),
            ]);

            return response()->json([
                'success' => true,
                'message' => $existingContact
                    ? 'Lead attached to existing Customer successfully!'
                    : 'Lead converted to Customer successfully!',
                'data' => $lead
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found. Please try again later.'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    private function updateLeadFromRawData(Lead $lead)
    {
        $rawData = json_decode($lead->raw_data, true);
        $submissions = collect($rawData['submissions'] ?? []);
        $submission = $submissions->first() ?? [];
        $formData = collect($submission['form_data'] ?? [])->mapWithKeys(fn($value, $key) => [strtolower($key) => $value])->toArray();
        $fieldMapping = [
            'name' => ['fname', 'name', 'firstname', 'first-name', 'first_name', 'fullname', 'full_name', 'yourname', 'your-name'],
            'email' => ['email', 'your-email', 'email-address', 'user_email'],
            'phone' => ['tel', 'tele', 'number', 'num', 'phone', 'telephone', 'your-phone', 'phone-number', 'phonenumber'],
            'note' => ['message', 'msg', 'desc', 'description', 'note'],
        ];
        $dataToSave = [];
        foreach ($fieldMapping as $column => $possibleFields) {
            foreach ($possibleFields as $field) {
                if (isset($formData[$field])) {
                    $dataToSave[$column] = $formData[$field];
                    break;
                }
            }
        }
        if (empty($lead->brand_key)) {
            $scriptToken = $rawData['script_token'] ?? ($submission['script_token'] ?? null);
            if ($scriptToken) {
                try {
                    $brand = Brand::all()->first(fn($b) => $b->script_token === $scriptToken);
                    if ($brand) {
                        $dataToSave['brand_key'] = $brand->brand_key;
                    }
                } catch (\Exception $e) {
                    Log::channel('webToLead')->warning('Brand lookup failed during conversion', [
                        'lead_id' => $lead->id,
                        'script_token' => $scriptToken,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
        if (!empty($dataToSave)) {
            $lead->update($dataToSave);
        }
    }




}

