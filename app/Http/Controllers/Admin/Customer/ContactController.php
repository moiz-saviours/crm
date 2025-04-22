<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use Illuminate\Support\Facades\Cache;
use App\Models\Team;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        $teams = Team::all();
        $countries = config('countries');
        $customer_contacts = CustomerContact::all();
        return view('admin.customers.contacts.index', compact('customer_contacts', 'brands', 'teams', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $countries = Cache::rememberForever('countries_list', fn() => config('countries'));
        return view('admin.customers.contacts.create', compact('brands', 'teams', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customer_contacts,email',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => [
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
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'Please select a valid brand.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'Please select a valid team.',
        ]);
        $customer_contact = new CustomerContact($request->only([
                'brand_key', 'team_key', 'name',
                'email', 'phone', 'address', 'city', 'state',
                'country', 'zipcode', 'ip_address', 'creator_type',
                'creator_id', 'status',
            ]) + ['special_key' => CustomerContact::generateSpecialKey()]);
        $customer_contact->save();
        $customer_contact->loadMissing('team', 'brand','company');
        return response()->json(['data' => $customer_contact, 'success' => 'Contact Created Successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerContact $customer_contact)
    {
        return response()->json(['customer_contact' => $customer_contact]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerContact $customer_contact)
    {
        if (!$customer_contact->id) return response()->json(['error' => 'Oops! Customer contact not found!']);
        $customer_contact->load('creator', 'company', 'invoices', 'payments','notes');
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        $teams = Team::where('status', 1)->orderBy('name')->get();
        $countries = config('countries');
        return view('admin.customers.contacts.edit', compact('customer_contact', 'brands', 'teams', 'countries'));
//        return response()->json(['customer_contact' => $customer_contact, 'brands' => $brands, 'teams' => $teams, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerContact $customer_contact)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,team_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customer_contacts,email,' . $customer_contact->id,
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => [
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
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'Please select a valid brand.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'Please select a valid team.',
        ]);
        $customer_contact->fill($request->only([
            'special_key', 'brand_key', 'team_key', 'name',
            'email', 'phone', 'address', 'city', 'state',
            'country', 'zipcode', 'ip_address', 'status',
        ]));
        $customer_contact->save();
        $customer_contact->loadMissing('team', 'brand','company');
        return response()->json(['data' => $customer_contact,'success' => 'Contact Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(CustomerContact $customer_contact)
    {
        try {
            if ($customer_contact->delete()) {
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
    public function change_status(Request $request, CustomerContact $customer_contact)
    {
        try {
            $customer_contact->status = $request->query('status');
            $customer_contact->save();
            return response()->json(['success' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
