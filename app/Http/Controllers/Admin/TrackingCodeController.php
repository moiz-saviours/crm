<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TrackingCodeController extends Controller
{
    public function tracking()
    {
        return view('admin.tracking-code.index');
    }
}
