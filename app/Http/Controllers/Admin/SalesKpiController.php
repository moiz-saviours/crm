<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SalesKpiController extends Controller
{
    public function index()
    {
        return view('admin.sales.index');
    }
}
