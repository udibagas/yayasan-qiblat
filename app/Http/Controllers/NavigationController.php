<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return [
            [
                'path' => '/home',
                'label' => 'Home',
                'icon' => 'home'
            ],
            [
                'path' => '/user',
                'label' => 'User',
                'icon' => 'user-lock'
            ],
            [
                'path' => '/postCategory',
                'label' => 'Post Category',
                'icon' => 'tags'
            ],
            [
                'path' => '/post',
                'label' => 'Post',
                'icon' => 'file'
            ],
            [
                'path' => '/donatur',
                'label' => 'Donatur',
                'icon' => 'user'
            ],
            [
                'path' => '/donation',
                'label' => 'Donasi',
                'icon' => 'money'
            ],
            [
                'path' => '/donationType',
                'label' => 'Paket Donasi',
                'icon' => 'money'
            ],
        ];
    }
}
