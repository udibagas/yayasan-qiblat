<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN);
    }

    public function index()
    {
        return view('layouts.backend');
    }
}
