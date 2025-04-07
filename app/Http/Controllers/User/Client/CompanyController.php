<?php

namespace App\Http\Controllers\User\Client;

use App\Http\Controllers\Controller;
use App\Models\AssignBrandAccount;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client_companies = ClientCompany::all();
        $client_contacts = ClientContact::active()->get();
        return view('user.clients.companies.index', compact('client_companies', 'client_contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.clients.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'c_contact_key' => 'required:exists:client_contacts,special_key',
            'name' => 'required|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ]);
        try {
            $client_company = new ClientCompany($request->only(['name', 'email', 'c_contact_key', 'description', 'url', 'status']) + ['special_key' => ClientCompany::generateSpecialKey()]);
            if ($request->hasFile('logo')) {
                $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $publicPath = public_path('assets/images/clients/companies/logos/');
                $request->file('logo')->move($publicPath, $originalFileName);
                $client_company->logo = $originalFileName;
            }
            DB::transaction(function () use ($request, $client_company) {
                $client_company->save();
            });
            $client_company->loadMissing('client_contact');
            return response()->json(['data' => $client_company, 'message' => 'Record created successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientCompany $client_company)
    {
        return view('user.clients.companies.show', compact('client_company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ClientCompany $client_company)
    {
        if ($request->ajax()) {
            return response()->json(['client_company' => $client_company]);
        }
        return view('user.client.companies.edit', compact('client_company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientCompany $client_company)
    {
        $request->validate([
            'c_contact_key' => 'required|exists:client_contacts,special_key',
            'name' => 'required|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|url',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ]);
        try {

            DB::transaction(function () use ($request, $client_company) {
                $client_company->fill($request->only(['name', 'email', 'description', 'status', 'c_contact_key', 'url']));
                if ($request->hasFile('logo')) {
                    $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                    $publicPath = public_path('assets/images/clients/companies/logos/');
                    if (!file_exists($publicPath)) {
                        mkdir($publicPath, 0777, true);
                    }
                    $request->file('logo')->move($publicPath, $originalFileName);
                    $client_company->logo = $originalFileName;
                }
                $client_company->save();
            });
            $client_company->loadMissing('client_contact');
            return response()->json(['data' => $client_company, 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function change_status(Request $request, ClientCompany $client_company)
    {
        try {
            $client_company->status = $request->query('status');
            $client_company->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
