<?php

namespace App\Http\Controllers\User\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerCompany;
use App\Models\CustomerContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $teams = $user->teams()->with('brands')->get();
        $teamKeys = $teams->pluck('team_key')->toArray();
        $all_contacts = CustomerContact::where(function ($query) use ($teamKeys) {
            $query->whereIn('team_key', $teamKeys)->orWhereMorphedTo('creator', auth()->user());
        })->active()->get();
        $my_contacts = $all_contacts->filter(function ($contact) {
            return $contact->creator_type === get_class(Auth::user()) && $contact->creator_id === Auth::id();
        });
        $domains = $all_contacts->map(function ($contact) {
            return substr(strrchr($contact->email, "@"), 1);
        })->unique();
        $existingDomains = CustomerCompany::whereIn('domain', $domains)->pluck('domain')->toArray();
        $domainsToFetch = $domains->diff($existingDomains);
        foreach ($domainsToFetch as $domain) {
            $response = Http::get('https://api.hunter.io/v2/domain-search', [
                'domain' => $domain,
                'api_key' => env('HUNTER_API_KEY'),
            ]);
            if ($response->successful() && isset($response->json()['data'])) {
                $companyData = $response->json()['data'];
                CustomerCompany::updateOrCreate(
                    ['domain' => $domain],
                    [
                    'name' => $companyData['organization'] ?? $domain,
                    'email' => 'no-reply@' . $domain,
                    'domain' => $domain,
                    'city' => $companyData['city'],
                    'state' => $companyData['state'],
                    'country' => $companyData['country'],
                    'zipcode' => $companyData['postal_code'],
                    'response' => json_encode($companyData),
                    'status' => 1,
                ]);
            }
        }
        $companies = CustomerCompany::whereIn('domain', $domains)->where('status', 1)->get();
//        $companies = Cache::remember('companies_list', config('cache.durations.short_lived'), fn() => CustomerCompany::whereIn('domain', $domains)->where('status', 1)->get());
        return view('user.customers.companies.index', compact('companies'));
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
        //
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
    public function destroy(CustomerCompany $company)
    {
        //
    }
}
