<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\CustomerCompany;
use App\Models\CustomerContact;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DealController extends Controller
{
    public function __construct()
    {
        // Share deal stages with all views
        view()->share('dealStages', [
            1 => 'Appointment Scheduled',
            2 => 'Qualified To Buy',
            3 => 'Presentation Scheduled',
            4 => 'Decision Maker Bought-In',
            5 => 'Contract Sent',
            6 => 'Closed Won',
            7 => 'Closed Lost'
        ]);
    }

    /**
     * Display a listing of the deals.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to start date.',
        ]);

        $startDate = isset($validated['start_date'])
            ? Carbon::createFromFormat('Y-m-d h:i:s A', $validated['start_date'], 'GMT+5')->setTimezone('UTC')
            : Carbon::now('GMT+5')->startOfMonth()->setTimezone('UTC');
        
        $endDate = isset($validated['end_date'])
            ? Carbon::createFromFormat('Y-m-d h:i:s A', $validated['end_date'], 'GMT+5')->setTimezone('UTC')
            : Carbon::now('GMT+5')->endOfMonth()->setTimezone('UTC');

        $actual_dates = [
            'start_date' => $startDate->copy()->timezone('GMT+5')->format('Y-m-d h:i:s A'),
            'end_date' => $endDate->copy()->timezone('GMT+5')->format('Y-m-d h:i:s A'),
        ];

        $query = Deal::whereBetween('created_at', [$actual_dates['start_date'], $actual_dates['end_date']])
            ->with(['company', 'contact']);

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('company', function ($deal) {
                    return $deal->company?->name ?? 'N/A';
                })
                ->editColumn('contact', function ($deal) {
                    return $deal->contact?->name ?? 'N/A';
                })
                ->editColumn('deal_stage', function ($deal) {
                    $stages = [
                        1 => 'Appointment Scheduled',
                        2 => 'Qualified To Buy',
                        3 => 'Presentation Scheduled',
                        4 => 'Decision Maker Bought-In',
                        5 => 'Contract Sent',
                        6 => 'Closed Won',
                        7 => 'Closed Lost',
                    ];
                    $color = $deal->deal_stage >= 6
                        ? ($deal->deal_stage == 6 ? 'success' : 'danger')
                        : 'warning';
                    return '<span class="badge bg-' . $color . ' text-white">' . ($stages[$deal->deal_stage] ?? 'Unknown') . '</span>';
                })
                ->editColumn('amount', fn($deal) => '$' . number_format($deal->amount, 2))
                ->editColumn('close_date', fn($deal) => optional($deal->close_date)->format('M d, Y'))
                ->editColumn('priority', function ($deal) {
                    if (!$deal->priority) return '';
                    $color = match ($deal->priority) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        default => 'secondary'
                    };
                    return '<span class="badge bg-' . $color . ' text-white">' . ucfirst($deal->priority) . '</span>';
                })
                ->editColumn('status', fn($deal) => '<span class="badge bg-' . ($deal->status ? 'success' : 'danger') . ' text-white">' . ($deal->status ? 'Active' : 'Inactive') . '</span>')
                ->addColumn('action', function ($deal) {
                    return '
                        <div class="dropdown text-center">
                            <a href="#" class="text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item editBtn" href="#" data-id="' . $deal->id . '">Edit</a></li>
                                <li><a class="dropdown-item deleteBtn" href="#" data-id="' . $deal->id . '">Delete</a></li>
                            </ul>
                        </div>
                    ';
                })



                ->rawColumns(['deal_stage', 'priority', 'status', 'action'])
                ->make(true);
        }

        // 👇 For initial view load only
        $companies = CustomerCompany::where('status', 1)->orderBy('name')->get(['id', 'special_key', 'domain', 'name', 'email', 'phone']);
        $contacts = CustomerContact::where('status', 1)->orderBy('name')->get(['id', 'special_key', 'name', 'email', 'phone']);
        $services = collect([
            ['id' => 1, 'name' => 'App Development'],
            ['id' => 2, 'name' => 'Animation Services'],
            ['id' => 3, 'name' => 'Marketing Services'],
            ['id' => 4, 'name' => 'Content Writing'],
            ['id' => 5, 'name' => 'Website Design'],
            ['id' => 6, 'name' => 'Logo Design']
        ])->map(fn($item) => (object)$item);

        return view('admin.deals.index', compact(
            'companies', 
            'contacts', 
            'services', 
            'actual_dates'
        ));
    }

    /**
     * Show the form for creating a new deal.
     */
    public function create()
    {
        $companies = CustomerCompany::where('status', 1)->orderBy('name')->get();
        $contacts = CustomerContact::where('status', 1)->orderBy('name')->get();
        $services = collect([
            ['id' => 1, 'name' => 'App Development'],
            ['id' => 2, 'name' => 'Animation Services'],
            ['id' => 3, 'name' => 'Marketing Services'],
            ['id' => 4, 'name' => 'Content Writing'],
            ['id' => 5, 'name' => 'Website Design'],
            ['id' => 6, 'name' => 'Logo Design']
        ])->map(function($item) {
            return (object)$item;
        });
        return view('admin.deals.create', compact(
            'companies',
            'contacts', 
            'services'
        ));
    }

    /**
     * Store a newly created deal in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'cus_company_key' => 'nullable|exists:customer_companies,special_key',
                'cus_contact_key' => 'nullable|exists:customer_contacts,special_key',
                'name' => 'required|string|max:255',
                'deal_stage' => 'required|integer|in:1,2,3,4,5,6,7',
                'amount' => 'nullable|numeric|min:0',
                'start_date' => 'nullable|date',
                'close_date' => 'nullable|date',
                'deal_type' => 'nullable|string|max:255',
                'priority' => 'nullable|in:low,medium,high',
                'services' => 'nullable',
                'is_contact_start_date' => 'nullable|boolean',
                'contact_start_date' => 'nullable|date|required_if:is_contact_start_date,1',
                'is_company_start_date' => 'nullable|boolean',
                'company_start_date' => 'nullable|date|required_if:is_company_start_date,1',
                'status' => 'required|in:0,1',
            ], [
                'cus_company_key.exists' => 'The selected company does not exist.',
                'cus_contact_key.exists' => 'The selected contact does not exist.',
                'name.required' => 'The deal name is required.',
                'deal_stage.required' => 'The deal stage is required.',
                'deal_stage.in' => 'The selected deal stage is invalid.',
                'amount.numeric' => 'The amount must be a valid number.',
                'services.exists' => 'The selected service does not exist.',
                'contact_start_date.required_if' => 'Contact start date is required when timeline activity is enabled.',
                'company_start_date.required_if' => 'Company start date is required when HubSpot timeline activity is enabled.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $deal = Deal::create([
                'cus_company_key' => $request->input('cus_company_key'),
                'cus_contact_key' => $request->input('cus_contact_key'),
                'name' => $request->input('name'),
                'deal_stage' => $request->input('deal_stage'),
                'amount' => $request->input('amount', 0.00),
                'start_date' => $request->input('start_date'),
                'close_date' => $request->input('close_date'),
                'deal_type' => $request->input('deal_type'),
                'priority' => $request->input('priority'),
                'services' => $request->input('services'),
                'is_contact_start_date' => $request->boolean('is_contact_start_date'),
                'contact_start_date' => $request->input('contact_start_date'),
                'is_company_start_date' => $request->boolean('is_company_start_date'),
                'company_start_date' => $request->input('company_start_date'),
                'status' => $request->input('status'),
                'creator_type' => auth()->user() ? get_class(auth()->user()) : null,
                'creator_id' => auth()->id(),
            ]);

            DB::commit();
            $deal->refresh();
            $deal->load([
                'company:id,special_key,domain,name,email,phone',
                'contact:id,special_key,name,email,phone',
            ]);

            if ($deal->created_at->isToday()) {
                $date = "Today at " . $deal->created_at->timezone('GMT+5')->format('g:i A') . " GMT+5";
            } else {
                $date = $deal->created_at->timezone('GMT+5')->format('M d, Y g:i A') . " GMT+5";
            }
            $deal->date = $date;

            return response()->json([
                'data' => $deal, 
                'success' => 'Deal created successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'An error occurred while creating the deal', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified deal.
     */
    public function show(Deal $deal)
    {
        $deal->load([
            'company:id,special_key,domain,name,email,phone',
            'contact:id,special_key,name,email,phone',
        ]);

        return response()->json(['deal' => $deal]);
    }


    /**
     * Show the form for editing the specified deal.
     */
    public function edit(Deal $deal)
    {
        $companies = CustomerCompany::where('status', 1)->orderBy('name')->get(['id', 'special_key','domain', 'name', 'email', 'phone']);
            $contacts = CustomerContact::where('status', 1)
        ->orderBy('name')
        ->get(['id', 'special_key', 'name', 'email', 'phone']);
        $services = collect([
            ['id' => 1, 'name' => 'App Development'],
            ['id' => 2, 'name' => 'Animation Services'],
            ['id' => 3, 'name' => 'Marketing Services'],
            ['id' => 4, 'name' => 'Content Writing'],
            ['id' => 5, 'name' => 'Website Design'],
            ['id' => 6, 'name' => 'Logo Design']
        ])->map(function($item) {
            return (object)$item;
        });

        return response()->json(['deal' => $deal, 'contacts' => $contacts, 'services' => $services, 'companies' => $companies]);
    }

    /**
     * Update the specified deal in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'cus_company_key' => 'nullable|exists:customer_companies,special_key',
                'cus_contact_key' => 'nullable|exists:customer_contacts,special_key',
                'name' => 'required|string|max:255',
                'deal_stage' => 'required|integer|in:1,2,3,4,5,6,7',
                'amount' => 'nullable|numeric|min:0',
                'start_date' => 'nullable|date',
                'close_date' => 'nullable|date',
                'deal_type' => 'nullable|string|max:255',
                'priority' => 'nullable|in:low,medium,high',
                'services' => 'nullable',
                'is_contact_start_date' => 'nullable|boolean',
                'contact_start_date' => 'nullable|date|required_if:is_contact_start_date,1',
                'is_company_start_date' => 'nullable|boolean',
                'company_start_date' => 'nullable|date|required_if:is_company_start_date,1',
                'status' => 'required|in:0,1',
            ], [
                'cus_company_key.exists' => 'The selected company does not exist.',
                'cus_contact_key.exists' => 'The selected contact does not exist.',
                'name.required' => 'The deal name is required.',
                'deal_stage.required' => 'The deal stage is required.',
                'deal_stage.in' => 'The selected deal stage is invalid.',
                'amount.numeric' => 'The amount must be a valid number.',
                'services.exists' => 'The selected service does not exist.',
                'contact_start_date.required_if' => 'Contact start date is required when timeline activity is enabled.',
                'company_start_date.required_if' => 'Company start date is required when HubSpot timeline activity is enabled.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $updateData = [
                'cus_company_key' => $request->input('cus_company_key'),
                'cus_contact_key' => $request->input('cus_contact_key'),
                'name' => $request->input('name'),
                'deal_stage' => $request->input('deal_stage'),
                'amount' => $request->input('amount', 0.00),
                'start_date' => $request->input('start_date'),
                'close_date' => $request->input('close_date'),
                'deal_type' => $request->input('deal_type'),
                'priority' => $request->input('priority'),
                'services' => $request->input('services'),
                'is_contact_start_date' => $request->boolean('is_contact_start_date'),
                'contact_start_date' => $request->input('contact_start_date'),
                'is_company_start_date' => $request->boolean('is_company_start_date'),
                'company_start_date' => $request->input('company_start_date'),
                'status' => $request->input('status'),
            ];

            $deal->update($updateData);
            DB::commit();

            $deal->load([
                'company:id,special_key,domain,name,email,phone',
                'contact:id,special_key,name,email,phone',
            ]);

            if ($deal->created_at->isToday()) {
                $date = "Today at " . $deal->created_at->timezone('GMT+5')->format('g:i A') . " GMT+5";
            } else {
                $date = $deal->created_at->timezone('GMT+5')->format('M d, Y g:i A') . " GMT+5";
            }
            $deal->date = $date;

            return response()->json([
                'data' => $deal, 
                'success' => 'Deal updated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'An error occurred while updating the deal', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified deal from storage.
     */
    public function delete(Deal $deal)
    {
        try {
            if ($deal->delete()) {
                return response()->json(['success' => 'The deal has been deleted successfully.']);
            }
            return response()->json(['error' => 'Unable to process deletion request at this time.'], 422);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal Server Error', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

 
}