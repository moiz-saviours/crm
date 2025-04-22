<?php

namespace App\Http\Controllers\AdminOld;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\PaymentMerchant;
use Illuminate\Http\Request;

class PaymentMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_merchants = PaymentMerchant::get();
        return view('admin.payment-merchants.index', compact('payment_merchants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where('status', 1)->orderBy('name')->get();
        return view('admin.payment-merchants.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_key' => 'nullable|exists:brands,brand_key',
            'name' => 'required|string|max:255',
            'descriptor' => 'nullable|string|max:255',
            'vendor_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'login_id' => 'nullable|string|max:255',
            'transaction_key' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1',
            'environment' => 'required|in:sandbox,production',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $paymentMerchant = PaymentMerchant::create([
            'brand_key' => $request->brand_key,
            'name' => $request->name,
            'descriptor' => $request->descriptor,
            'vendor_name' => $request->vendor_name,
            'email' => $request->email,
            'login_id' => $request->login_id,
            'transaction_key' => $request->transaction_key,
            'limit' => $request->limit,
            'description' => $request->description,
            'environment' => $request->environment,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.client.index')
            ->with('success', 'Payment Merchant created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(PaymentMerchant $paymentMerchant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMerchant $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMerchant $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMerchant $client)
    {
        //
    }
}
