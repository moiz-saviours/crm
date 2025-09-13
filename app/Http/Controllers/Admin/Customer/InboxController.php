<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;

class InboxController extends Controller
{
    public function index()
    {
        return view('admin.customers.inbox.index');
    }
}
