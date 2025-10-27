<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Team;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
    public function index(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'team_key' => 'nullable|string',
            'brand_key' => 'nullable|string',
        ], [
            [
                'start_date.required' => 'The start date is required.',
                'start_date.date' => 'The start date must be a valid date.',
                'end_date.required' => 'The end date is required.',
                'end_date.date' => 'The end date must be a valid date.',
                'end_date.after_or_equal' => 'The end date must be a valid date.',
                'team_key.required' => 'The team key is required.',
                'team_key.string' => 'The team key must be a valid string.',
                'brand_key.required' => 'The brand key is required.',
                'brand_key.string' => 'The brand key must be a valid string.',
            ]
        ]);
        $startDate = isset($validated['start_date'])
            ? Carbon::createFromFormat('Y-m-d h:i:s A', $validated['start_date'], 'GMT+5')->setTimezone('UTC')
            : Carbon::now('GMT+5')->startOfMonth()->setTimezone('UTC');
        $endDate = isset($validated['end_date'])
            ? Carbon::createFromFormat('Y-m-d h:i:s A', $validated['end_date'], 'GMT+5')->setTimezone('UTC')
            : Carbon::now('GMT+5')->endOfMonth()->setTimezone('UTC');
        $teamKey = $validated['team_key'] ?? 'all';
        $brandKey = $validated['brand_key'] ?? 'all';
        $actual_dates = [
            'start_date' => $startDate->copy()->timezone('GMT+5')->format('Y-m-d h:i:s A'),
            'end_date' => $endDate->copy()->timezone('GMT+5')->format('Y-m-d h:i:s A'),
        ];
        $tab = $request->get('tab', 'all');
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
        $leads = Lead::whereBetween('created_at', [$actual_dates['start_date'], $actual_dates['end_date']])
            ->when($teamKey !== 'all', fn($q) => $q->where('team_key', $teamKey))
            ->when($brandKey !== 'all', fn($q) => $q->where('brand_key', $brandKey));
//        if ($tab === 'my') {
//            $leads->where('assigned_to', auth()->id());
//        }
        $leads = $leads->with('customer_contact:id,special_key,name', 'brand:brand_key,name', 'team:team_key,name', 'leadStatus:id,name')->get();
        if ($leads->isEmpty() && !isset($validated['start_date']) && !isset($validated['end_date']) && $brandKey == 'all' && $teamKey == 'all') {
            $lastRecordDate = Lead::latest('created_at')->value('created_at');
            if ($lastRecordDate) {
                $startDate = Carbon::parse($lastRecordDate)->startOfMonth();
                $endDate = Carbon::parse($lastRecordDate)->endOfMonth();
                $leads = Lead::whereBetween('created_at', [$startDate, $endDate])
                    ->when($teamKey !== 'all', fn($q) => $q->where('team_key', $teamKey))
                    ->when($brandKey !== 'all', fn($q) => $q->where('brand_key', $brandKey))
                    ->with('customer_contact:id,special_key,name', 'brand:brand_key,name', 'team:team_key,name', 'leadStatus:id,name')->get();
                $actual_dates = [
                    'start_date' => $startDate->timezone('GMT+5')->format('Y-m-d h:i:s A'),
                    'end_date' => $endDate->timezone('GMT+5')->format('Y-m-d h:i:s A'),
                ];
            }
        }
        $leads = $leads->map(function ($lead) {
            if ($lead->created_at->isToday()) {
                $lead->date = "Today at " . $lead->created_at->timezone('GMT+5')->format('g:i A') . " GMT+5";
            } else {
                $lead->date = $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') . " GMT+5";
            }
            return $lead;
        });
        if ($request->ajax()) {
            return response()->json(['success' => true, 'data' => $leads, 'actual_dates' => $actual_dates, 'count' => $leads->count()]);
        }
        return view('admin.leads.index', compact('leads', 'brands', 'teams', 'customer_contacts', 'actual_dates'));
    }

    /**
     * Show the form for creating a new lead.
     */
    public function create()
    {
//        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
//        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $brands = Brand::where('status', 1)->orderBy('name')->get();
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
            $lead->loadMissing('customer_contact', 'brand', 'team', 'leadStatus');
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
        //$brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        //$teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $customer_contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
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
                'country' => $request->input('country'),
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
                }], 'leadStatus');
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
     * Remove the specified resource from storage.
     */
    public function delete(Lead $lead)
    {
        try {
            if ($lead->delete()) {
                return response()->json(['success' => 'The record has been deleted successfully.']);
            }
            return response()->json(['error' => 'Unable to process deletion request at this time.'], 422);

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


//    public function storeFromScript(Request $request)
//    {
//        $userAgent = $request->userAgent();
//
//        // Default device info
//        $deviceInfo = [
//            'user_agent' => $userAgent,
//            'browser_name' => $this->getBrowserName($userAgent),
//        ];
//        $deviceInfo['visitor_id'] = $request->visitor_id ?? null;
//
//        try {
//            $userIp = $request->input('device_info.public_ip')
//                ?? $request->header('CF-Connecting-IP')
//                ?? $request->ip();
//
//
//            $ipapiRes = Http::timeout(5)->get("http://ip-api.com/json/{$userIp}");
//            if ($ipapiRes->successful()) {
//                $location = $ipapiRes->json();
//
//                $deviceInfo = array_merge($deviceInfo, [
//                    'ip' => $location['query'] ?? null,
//                    'city' => $location['city'] ?? null,
//                    'state' => $location['regionName'] ?? null,
//                    'zipcode' => $location['zip'] ?? null,
//                    'country' => $location['country'] ?? null,
//                    'latitude' => $location['lat'] ?? null,
//                    'longitude'=> $location['lon'] ?? null,
//                ]);
//
//                if (!empty($location['lat']) && !empty($location['lon'])) {
//                    $url = "https://nominatim.openstreetmap.org/reverse?lat={$location['lat']}&lon={$location['lon']}&format=json&accept-language=en";
//
//                    $revGeo = Http::withHeaders([
//                        'User-Agent' => 'MyLaravelApp/1.0 (mydomain.com)'
//                    ])->get($url);
//
//                    if ($revGeo->successful()) {
//                        $revData = $revGeo->json();
//                        $deviceInfo['address'] = $revData['display_name'] ?? null;
//                        if (empty($deviceInfo['zipcode']) && isset($revData['address']['postcode'])) {
//                            $deviceInfo['zipcode'] = $revData['address']['postcode'];
//                        }
//                    }
//                }
//            }
//        } catch (\Exception $ex) {
//            $deviceInfo['location_error'] = 'Unable to fetch location';
//        }
//
//        $formData = collect($request->form_data)
//            ->mapWithKeys(function ($value, $key) {
//                return [strtolower($key) => $value];
//            })
//            ->toArray();
//
//        $fieldMapping = [
//            'name' => ['fname','name','firstname','first-name','first_name','fullname','full_name','yourname','your-name'],
//            'email' => ['email'],
//            'phone' => ['tel','tele','number','num','phone','telephone','your-phone','phone-number','phonenumber'],
//            'note' => ['message','msg','desc','description','note'],
//        ];
//
//        $dataToSave = [];
//        foreach ($fieldMapping as $column => $possibleFields) {
//            foreach ($possibleFields as $field) {
//                if (isset($formData[$field])) {
//                    $dataToSave[$column] = $formData[$field];
//                    break;
//                }
//            }
//        }
//
//
//        try {
//            $brand = Brand::all()->firstWhere('script_token', $request->script_token);
//            if (!$brand) {
//                return response()->json(['error' => 'Invalid script token.'], 404);
//            }
//
//            $lead = Lead::create([
//                'brand_key' => $brand->brand_key,
//                'lead_status_id' => 1,
//                'name' => $dataToSave['name'] ?? "",
//                'email' => $dataToSave['email'] ?? "",
//                'phone' => $dataToSave['phone'] ?? "",
//                'note' => $dataToSave['note'] ?? "",
//                'lead_response' => json_encode($request->form_data),
//                'device_info' => json_encode($deviceInfo),
//                'city' => $deviceInfo['city'] ?? "",
//                'state' => $deviceInfo['state'] ?? "",
//                'zipcode' => $deviceInfo['zipcode'] ?? "",
//                'country' => $deviceInfo['country'] ?? "",
//                'address' => $deviceInfo['address'] ?? "",
//                'visitor_id' => $deviceInfo['visitor_id'] ?? "",
//            ]);
//
//            return response()->json([
//                'message' => 'Lead saved successfully!',
//                'lead_id' => $lead->id,
//                'device_info' => $deviceInfo
//            ]);
//        } catch (\Exception $e) {
//            return response()->json([
//                'error' => $e->getMessage()
//            ], 500);
//        }
//    }
    public function storeFromScript(Request $request)
    {
        try {
            /** ----------------------------------------------------------------
             * STEP 0: Handle navigator.sendBeacon() raw JSON payload
             * ----------------------------------------------------------------*/
            Log::channel('webToLead')->info('StoreFromScript Incoming:', ['data' => $request->all()]);
            $lead = Lead::create([
                'lead_status_id' => 1,
                'raw_data' => json_encode($request->all()),
            ]);
            /** ----------------------------------------------------------------
             * STEP 1: Validate brand token & create raw record
             * ----------------------------------------------------------------*/

            $submissions = collect($request->input('submissions', []));
            $submission = $submissions->first() ?? [];

            try {
                $scriptToken = $request->input('script_token') ?? ($submission['script_token'] ?? null);
                $brand = Brand::all()->first(fn($b) => $b->script_token === $scriptToken);

                // Assigned team key (first team of brand)
                $team_Key = $brand?->assignedTeams->first()?->team?->team_key;

            } catch (\Exception $e) {
                Log::channel('webToLead')->error('Brand/Team fetch error:', [
                    'script_token' => $scriptToken ?? null,
                    'error' => $e->getMessage(),
                ]);

            }

            $leadId = $lead->id;
            /** ----------------------------------------------------------------
             * STEP 2: Prepare device info
             * ----------------------------------------------------------------*/
            $userAgent = $request->userAgent();
            $deviceInfo = [
                'user_agent' => $userAgent,
                'browser_name' => $this->getBrowserName($userAgent),
                'visitor_id' => $request->visitor_id ?? null,
            ];
            try {
                // Step 1: Try to detect automatically
                $userIp = $request->server('HTTP_X_FORWARDED_FOR')
                    ?? $request->server('REMOTE_ADDR')
                    ?? $request->ip();
                // Step 2: If running on localhost, fetch public IP from API
                if (in_array($userIp, ['127.0.0.1', '::1'])) {
                    try {
                        $ipResponse = Http::timeout(5)->get('https://api64.ipify.org?format=json');
                        if ($ipResponse->successful()) {
                            $userIp = $ipResponse->json()['ip'];
                        }
                    } catch (\Exception $e) {
                        Log::channel('webToLead')->warning('Unable to fetch public IP on localhost', ['error' => $e->getMessage()]);
                    }
                }
                Log::channel('webToLead')->info('Detected IP Automatically:', ['ip' => $userIp]);
                // Step 3: Fetch location info from IP
                $ipapiRes = Http::timeout(5)->get("http://ip-api.com/json/{$userIp}");
                if ($ipapiRes->successful()) {
                    $location = $ipapiRes->json();
                    $deviceInfo = array_merge($deviceInfo, [
                        'ip' => $location['query'] ?? null,
                        'city' => $location['city'] ?? null,
                        'state' => $location['regionName'] ?? null,
                        'zipcode' => $location['zip'] ?? null,
                        'country' => $location['country'] ?? null,
                        'latitude' => $location['lat'] ?? null,
                        'longitude' => $location['lon'] ?? null,
                    ]);
                    if (!empty($location['lat']) && !empty($location['lon'])) {
                        $url = "https://nominatim.openstreetmap.org/reverse?lat={$location['lat']}&lon={$location['lon']}&format=json&accept-language=en";
                        $revGeo = Http::withHeaders([
                            'User-Agent' => 'MyLaravelApp/1.0 (mydomain.com)'
                        ])->get($url);
                        if ($revGeo->successful()) {
                            $revData = $revGeo->json();
                            $deviceInfo['address'] = $revData['display_name'] ?? null;
                            if (empty($deviceInfo['zipcode']) && isset($revData['address']['postcode'])) {
                                $deviceInfo['zipcode'] = $revData['address']['postcode'];
                            }
                        }
                    }
                }
            } catch (\Exception $ex) {
                $deviceInfo['location_error'] = 'Unable to fetch location';
            }
            /** ----------------------------------------------------------------
             * STEP 3: Map form data to proper fields
             * ----------------------------------------------------------------*/


            $formData = collect($submission['form_data'] ?? [])
                ->mapWithKeys(fn($value, $key) => [strtolower($key) => $value])
                ->toArray();
            $fieldMapping = [
                'name' => ['fname', 'name', 'firstname', 'first-name', 'first_name', 'fullname', 'full_name', 'yourname', 'your-name'],
                'email' => ['email'],
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
            /** ----------------------------------------------------------------
             * STEP 4: Update record with processed data
             * ----------------------------------------------------------------*/
            $lead->update([
                'brand_key' => $brand?->brand_key,
                'team_key' => $team_Key,
                'name' => $dataToSave['name'] ?? '',
                'email' => $dataToSave['email'] ?? '',
                'phone' => $dataToSave['phone'] ?? '',
                'note' => $dataToSave['note'] ?? '',
                'lead_response' => json_encode($submission['form_data'] ?? []),
                'device_info' => json_encode($deviceInfo),
                'city' => $deviceInfo['city'] ?? '',
                'state' => $deviceInfo['state'] ?? '',
                'zipcode' => $deviceInfo['zipcode'] ?? '',
                'country' => $deviceInfo['country'] ?? '',
                'address' => $deviceInfo['address'] ?? '',
                'visitor_id' => $deviceInfo['visitor_id'] ?? '',
            ]);
            /** ----------------------------------------------------------------
             * STEP 5: Auto-link with Customer Contact (if exists)
             * ----------------------------------------------------------------*/
            if (!empty($lead->email)) {
                $existingContact = CustomerContact::where('email', $lead->email)->first();
                if ($existingContact) {
                    $lead->update([
                        'cus_contact_key' => $existingContact->special_key,
                    ]);
                    Log::channel('webToLead')->info('Lead auto-linked to existing customer', [
                        'lead_id' => $lead->id,
                        'cus_contact_key' => $existingContact->special_key,
                    ]);
                }
            }
            /** ----------------------------------------------------------------
             * STEP 5: Final response
             * ----------------------------------------------------------------*/
            return response()->json([
                'message' => 'Lead stored and updated successfully!',
                'lead_id' => $leadId,
            ]);

        } catch (\Exception $e) {
            Log::channel('webToLead')->error('StoreFromScript Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function getBrowserName($userAgent)
    {
        $browsers = [
            'Edge' => 'Edg',
            'Opera' => 'OPR',
            'Vivaldi' => 'Vivaldi',
            'Brave' => 'Brave',
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Internet Explorer' => 'MSIE|Trident'
        ];
        foreach ($browsers as $browser => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                return $browser;
            }
        }
        return 'Unknown';
    }

    public function convert_to_customer(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $deviceInfo = json_decode($lead->device_info, true);
            $existingContact = CustomerContact::where('email', $lead->email)->first();
            if ($existingContact) {
                $customer_contact = $existingContact;
            } else {
                $customer_contact = new CustomerContact([
                    'brand_key' => $lead->brand_key,
                    'team_key' => null,
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
            $lead->load('customer_contact:id,special_key,name', 'leadStatus:id,name');
            UserActivity::create([
                'event_type' => 'conversion',
                'visitor_id' => $lead->visitor_id,
                'event_data' => json_encode([
                    'message' => $existingContact
                        ? "Lead attached to existing customer"
                        : "Lead converted to new customer",
                    'customer_name' => $customer_contact->name,
                    'customer_email' => $customer_contact->email,
                    'converted_by' => auth()->user()->name ?? 'System',
                ]),
            ]);
            return response()->json([
                'success' => true,
                'message' => $existingContact
                    ? 'Lead attached to existing Customer successfully!'
                    : 'Lead converted to Customer successfully!',
                'data' => $lead
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
