<?php

namespace App\Http\Controllers\User\Client;

use App\Http\Controllers\Controller;
use App\Models\AssignBrandAccount;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $this->authorize('viewAny', ClientContact::class);
        $client_contacts = ClientContact::all();
        return view('user.clients.contacts.index', compact('client_contacts'));
    }

    /**
     * Showing companies of specified resource.
     */
    public function companies($client_contact)
    {
//        $this->authorize('view', $client_contact);
        if (!$client_contact) {
            return response()->json(['error' => 'Oops! Contact not found.'], 404);
        }
        $client_companies = ClientCompany::where('c_contact_key', $client_contact)->where('status', 1)->get();
        return response()->json(['client_companies' => $client_companies]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $this->authorize('create', ClientContact::class);
        $countries = Cache::rememberForever('countries_list', fn() => config('countries'));
        return view('user.clients.contacts.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $this->authorize('create', ClientContact::class);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:client_contacts,email',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20',
        ]);
        $client_contact = new ClientContact($request->only([
                'name', 'email', 'phone', 'address', 'city', 'state',
                'country', 'zipcode', 'ip_address', 'status',
            ]) + ['special_key' => ClientContact::generateSpecialKey()]);
        DB::transaction(function () use ($request, $client_contact) {
            $client_contact->save();
        });
        return response()->json(['data' => $client_contact, 'success' => 'Record created successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientContact $client_contact)
    {
//        $this->authorize('view', $client_contact);
        return response()->json(['client_contact' => $client_contact]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientContact $client_contact)
    {
//        $this->authorize('update', $client_contact);
//        $client_contact = $client_contact->forUser(auth()->user())->get();
//        if (!$client_contact || empty($client_contact) || count($client_contact) < 1) return response()->json(['error' => 'Record not found!'], 404);
        if (!$client_contact) return response()->json(['error' => 'Record not found!'], 404);
        return response()->json(['client_contact' => $client_contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientContact $client_contact)
    {
//        $this->authorize('update', $client_contact);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:client_contacts,email,' . $client_contact->id,
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:10',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:0,1',
            'phone' => 'nullable|regex:/^(\+?\d{1,3})[\d\s().-]+$/|min:8|max:20'
        ]);
        DB::transaction(function () use ($request, $client_contact) {
            $client_contact->update($request->only([
                'name', 'email', 'phone', 'address', 'city', 'state',
                'country', 'zipcode', 'ip_address', 'status',
            ]));
        });
        return response()->json(['data' => $client_contact, 'success' => 'Record updated successfully!']);
    }

    /**
     * Change the specified resource status from storage.
     */
    public function change_status(Request $request, ClientContact $client_contact)
    {
//        $this->authorize('changeStatus', $client_contact);
        try {
            $client_contact->status = $request->query('status');
            $client_contact->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
