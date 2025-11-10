<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ClientCompany;
use App\Models\ClientContact;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index()
    {
        if (!Auth::user()->department->name === 'Operations' && Auth::user()->role->name === 'IT Executive') {

            if (request()->ajax()) {
                return response()->json([
                    'status' => false,
                    'error' => 'Permission denied',
                    'message' => 'You do not have permission to edit this team.'
                ], 403);
            }

            return redirect()
                ->back()
                ->with('error', 'You do not have permission to edit this team.');
        }

        if (Auth::user()->department->name === 'Operations' && Auth::user()->role->name === 'IT Executive') {
            $brands = Brand::select('id','brand_key','name','url','logo','email','description','status')->get();
            $clientContacts = ClientContact::where('status', 1)->get();
            $edit_brand = session()->has('edit_brand') ? session()->get('edit_brand') : null;
            return view('user.brands.index', compact('brands', 'edit_brand', 'clientContacts'));
        }else{
            $user = Auth::user();
            $teams = $user->teams()->with('brands')->get();
            return view('user.brands.index', compact('teams'));
        }

       }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'url' => 'nullable|url',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ]);
        try {
            $brand = new Brand($request->only(['name', 'url', 'email', 'description', 'status']));
            if ($request->hasFile('logo')) {
                $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $publicPath = public_path('assets/images/brand-logos');
                $request->file('logo')->move($publicPath, $originalFileName);
                $brand->logo = $originalFileName;
            } else if ($request->logo_url) {
                $brand->logo = $request->logo_url;
            }
            $brand->save();

            return response()->json(['data' => $brand, 'message' => 'Record created successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function edit(Request $request, Brand $brand)
    {
//        if ($request->ajax()) {
//            $brand->load(['client_contacts:id,special_key,name,email', 'client_companies:id,special_key,c_contact_key,name,email', 'client_accounts:id,c_contact_key,c_company_key,name,vendor_name,email']);
//            return response()->json($brand);
//        }
        if ($request->ajax()) {
            return response()->json($brand);
        }
        session(['edit_brand' => $brand]);
        return response()->json(['data' => $brand]);
//        return redirect()->route('user.brand.index');
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|max:255',
            'url' => 'nullable|url',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_url' => 'nullable|url',
            'email' => 'nullable|email',
            'description' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1',
        ]);
        try {
            $brand->fill($request->only(['name', 'email', 'description', 'status', 'url']));
            if ($request->hasFile('logo')) {
                $originalFileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $publicPath = public_path('assets/images/brand-logos');
                $request->file('logo')->move($publicPath, $originalFileName);
                $brand->logo = $originalFileName;
            } else if ($request->logo_url) {
                $brand->logo = rawurlencode($request->logo_url);
            }
            $brand->save();
//            DB::transaction(function () use ($request, $brand) {
//                if ($request->has('client_accounts')) {
//                    $selectedAccounts = $request->input('client_accounts');
//                    $relatedCompanies = ClientCompany::whereHas('client_accounts', function ($query) use ($selectedAccounts) {
//                        $query->whereIn('id', $selectedAccounts);
//                    })->pluck('special_key')->toArray();
//                    $relatedContacts = ClientContact::whereHas('client_companies', function ($query) use ($relatedCompanies) {
//                        $query->whereIn('c_contact_key', $relatedCompanies);
//                    })->pluck('special_key')->toArray();
//                } else {
//                    $selectedAccounts = [];
//                    $relatedCompanies = [];
//                    $relatedContacts = [];
//                }
//                $selectedCompanies = array_unique(array_merge($request->input('client_companies', []), $relatedCompanies));
//                $selectedContacts = array_unique(array_merge($request->input('client_contacts', []), $relatedContacts));
//                $brand->client_accounts()->sync($selectedAccounts);
//                $brand->client_companies()->sync($selectedCompanies);
//                $brand->client_contacts()->sync($selectedContacts);
//            });
            return response()->json(['data' => $brand, 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function change_status(Request $request, Brand $brand)
    {
        try {
            $brand->status = $request->query('status');
            $brand->save();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => ' Internal Server Error', 'message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }
}
