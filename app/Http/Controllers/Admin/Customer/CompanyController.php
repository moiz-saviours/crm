<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerContact;
use App\Models\CustomerCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Fetch company data for a list of domains using the Hunter.io API.
     *
     * @param \Illuminate\Support\Collection $domains
     * @return array
     */
    private function fetchCompaniesFromDomains($domains)
    {
        if (!env('HUNTER_API_KEY')) {
            Log::error('Hunter.io API key is missing.');
            return [];
        }
        $fetchedCompanies = [];
        foreach ($domains as $domain) {
            $response = Http::retry(3, 100)->get('https://api.hunter.io/v2/domain-search', [
                'domain' => $domain,
                'api_key' => env('HUNTER_API_KEY'),
            ]);
            if ($response->successful() && isset($response->json()['data'])) {
                $companyData = $response->json()['data'];
                $company = CustomerCompany::updateOrCreate(
                    ['domain' => $domain],
                    [
                        'name' => $companyData['organization'] ?? ucfirst(preg_replace('/^www\./', '', preg_replace('/\.(com|net|org|co|io)$/', '', parse_url('http://' . $domain, PHP_URL_HOST)))) ?? $domain,
                        'email' => 'no-reply@' . $domain,
                        'address' => $companyData['street'] ?? null,
                        'city' => $companyData['city'] ?? null,
                        'state' => $companyData['state'] ?? null,
                        'country' => $companyData['country'] ?? null,
                        'zipcode' => $companyData['postal_code'] ?? null,
                        'response' => json_encode($companyData),
                        'status' => 1,
                    ]
                );
                CustomerContact::where('email', 'LIKE', "%@$domain")->whereNull('cus_company_key')->update(['cus_company_key' => $company->special_key]);
                $contactIds = CustomerContact::where('email', 'LIKE', "%@{$domain}")->pluck('special_key')->toArray();
                if (!empty($contactIds)) {
                    $company->contacts()->syncWithoutDetaching($contactIds);
                }
                $fetchedCompanies[] = $company;
            } else {
                Log::error('Hunter.io API failed', ['domain' => $domain, 'response' => $response->body()]);
            }
        }
        return $fetchedCompanies;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $all_contacts = CustomerContact::where('status', 1)->get();
        $domains = $all_contacts->map(fn($contact) => substr(strrchr($contact->email, "@"), 1))->unique();
        $existingCompanies = CustomerCompany::whereIn('domain', $domains)->get();
        foreach ($existingCompanies as $company) {
            CustomerContact::where('email', 'LIKE', "%@{$company->domain}")->whereNull('cus_company_key')->update(['cus_company_key' => $company->special_key]);
            $contactIds = CustomerContact::where('email', 'LIKE', "%@{$company->domain}")->pluck('special_key')->toArray();
            if (!empty($contactIds)) {
                $company->contacts()->syncWithoutDetaching($contactIds);
            }
        }
        $existingDomains = $existingCompanies->pluck('domain');
        $domainsToFetch = $domains->diff($existingDomains);
        if ($domainsToFetch->isNotEmpty()) {
            $this->fetchCompaniesFromDomains($domainsToFetch);
        }
        $customer_companies = CustomerCompany::whereIn('domain', $domains)->where('status', 1)->get();
        return view('admin.customers.companies.index', compact('customer_companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerCompany $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerCompany $company)
    {
        return view('admin.customers.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerCompany $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(CustomerCompany $company)
    {
        try {
            if ($company->delete()) {
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
    public function change_status(Request $request, CustomerCompany $company)
    {
        try {
            $company->status = $request->query('status');
            $company->save();
            return response()->json(['success' => 'Record status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
