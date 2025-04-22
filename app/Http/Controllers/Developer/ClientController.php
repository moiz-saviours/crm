<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CustomerContact;
use Illuminate\Support\Facades\Cache;
use App\Models\Team;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = CustomerContact::where('status', 1)->get();
        return view('developer.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $countries = Cache::rememberForever('countries_list', fn() => config('countries'));
        return view('developer.clients.create', compact('brands', 'teams', 'countries'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,brand_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
        ],[
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'Please select a valid brand.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'Please select a valid team.',
        ]);

        $client = new CustomerContact($request->only([
                'brand_key', 'team_key', 'name',
                'email', 'phone', 'address', 'city', 'state',
                'country', 'zipcode', 'ip_address', 'status',
            ]) + ['client_key' => CustomerContact::generateClientKey()]);

        $client->save();

        return redirect()->route('developer.client.index')->with('success', 'CustomerContact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerContact $client)
    {
        return view('developer.clients.edit', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerContact $client)
    {
        if (!$client->id) return redirect()->route('developer.client.index')->with('error', 'Record not found.');

        $brands = Cache::remember('brands_list', config('cache.durations.short_lived'), fn() => Brand::where('status', 1)->orderBy('name')->get());
        $teams = Cache::remember('teams_list', config('cache.durations.short_lived'), fn() => Team::where('status', 1)->orderBy('name')->get());
        $countries = Cache::rememberForever('countries_list', fn() => config('countries'));

        return view('developer.clients.edit', compact('client', 'brands', 'teams', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerContact $client)
    {
        $request->validate([
            'brand_key' => 'required|integer|exists:brands,brand_key',
            'team_key' => 'nullable|integer|exists:teams,brand_key',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
        ], [
            'brand_key.required' => 'The brand field is required.',
            'brand_key.integer' => 'The brand must be a valid integer.',
            'brand_key.exists' => 'Please select a valid brand.',
            'team_key.required' => 'The team field is required.',
            'team_key.integer' => 'The team must be a valid integer.',
            'team_key.exists' => 'Please select a valid team.',
        ]);

        $client->fill($request->only([
            'client_key', 'brand_key', 'team_key', 'name',
            'email', 'phone', 'address', 'city', 'state',
            'country', 'zipcode', 'ip_address', 'status',
        ]));

        $client->save();

        return redirect()->route('developer.client.index')->with('success', 'CustomerContact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(CustomerContact $client)
    {
        try {
            if ($client->delete()) {
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
    public function change_status(Request $request, CustomerContact $client)
    {
        try {
            $client->status = $request->query('status');
            $client->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
