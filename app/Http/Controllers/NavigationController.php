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
                'path' => '/program',
                'label' => 'Program',
                'icon' => 'list'
            ],
            [
                'path' => '/programPackage',
                'label' => 'Paket Program',
                'icon' => 'list'
            ],
            [
                'path' => '/achievement',
                'label' => 'Prestasi',
                'icon' => 'chart-bar'
            ],
            // [
            //     'path' => '/programGallery',
            //     'label' => 'Galeri Program',
            //     'icon' => 'image'
            // ],
            [
                'path' => '/donor',
                'label' => 'Donor',
                'icon' => 'users'
            ],
            [
                'path' => '/donation',
                'label' => 'Donasi',
                'icon' => 'money-bill-alt'
            ],
            [
                'path' => '/currencyRate',
                'label' => 'Currency Rate',
                'icon' => 'money-bill-alt'
            ],
            [
                'path' => '/carousel',
                'label' => 'Slider',
                'icon' => 'image'
            ],
            [
                'path' => '/post',
                'label' => 'Post',
                'icon' => 'file'
            ],
            [
                'path' => '/postCategory',
                'label' => 'Post Category',
                'icon' => 'tags'
            ],
            // [
            //     'path' => '/team',
            //     'label' => 'Team',
            //     'icon' => 'users'
            // ],
            [
                'path' => '/socialMedia',
                'label' => 'Media Sosial',
                'icon' => 'list'
            ],
            [
                'path' => '/user',
                'label' => 'User',
                'icon' => 'user-lock'
            ],
            [
                'path' => '/setting',
                'label' => 'Setting',
                'icon' => 'cogs'
            ],
            [
                'path' => '/backup',
                'label' => 'Backup',
                'icon' => 'database'
            ],
        ];
    }
}
