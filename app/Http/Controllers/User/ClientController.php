<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        return view('user.clients.index');
    }
}
