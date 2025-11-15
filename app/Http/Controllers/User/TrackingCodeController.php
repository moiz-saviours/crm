<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrackingCodeController extends Controller
{
    public function tracking()
    {
        return view('user.tracking-code.index');
    }
}

