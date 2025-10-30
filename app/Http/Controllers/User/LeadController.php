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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function index()
    {
        $all_leads = Lead::whereIn('brand_key', Auth::user()->teams()->with(['brands' => function ($query) {
            $query->where('status', 1);
        }])->get()->pluck('brands.*.brand_key')->flatten())
            ->whereIn('team_key', Auth::user()->teams()->pluck('teams.team_key')->flatten()->unique())
            ->with(['brand', 'customer_contact', 'leadStatus'])->get();
        $lead_statuses = LeadStatus::where('status', 1)->get();
        return view('user.leads.index', compact('all_leads', 'lead_statuses'));
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

