<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Email;

class InboxController extends Controller
{
    public function index()
    {
        $emails = Email::all();
        return view('admin.customers.inbox.index', compact('emails'));
    }
}
