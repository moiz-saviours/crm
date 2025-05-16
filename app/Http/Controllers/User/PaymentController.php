<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $query = Payment::query();
        if (Auth::user()->department->name === 'Operations' && Auth::user()->role->name === 'Accounts') {
            $query->with(['customer_contact']);
        } else if (Auth::user()->department->name === 'Sales') {
            $query->whereIn('brand_key', Auth::user()->teams()->with(['brands' => function ($query) {
                $query->where('status', 1);
            }])->get()->pluck('brands.*.brand_key')->flatten())
                ->whereIn('team_key', Auth::user()->teams()->pluck('teams.team_key')->flatten()->unique())
                ->with(['customer_contact']);
        } else {
            $query->whereNull('id');
        }
        $all_payments = $query->orderBy('payment_date')->get();
        $my_payments = $all_payments->filter(function ($payment) {
            return $payment->agent_id === Auth::id();
        });
        $my_payments = [];
        return view('user.payment.index', compact('all_payments', 'my_payments'));
    }
}
