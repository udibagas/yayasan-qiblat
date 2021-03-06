<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Team;
use App\Carousel;
use App\Program;
use App\SocialMedia;
use App\ProgramGallery;
use App\Post;
use App\PostCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $setting = Setting::all();
        $settings = [];

        foreach ($setting as $s) {
            $settings[$s->name] = $s->value;
        }

        return view('home', [
            'settings' => $settings,
            'team' => Team::all(),
            'sliders' => Carousel::active()->get(),
            'programs' => Program::all(),
            'socialMedia' => SocialMedia::all(),
            'galleries' => ProgramGallery::limit(6)->latest()->get(),
            'pages' => Post::active()->page()->get(),
            'categories' => PostCategory::where('parent_id', null)->get(),
            // untuk SEO
            'title' => __('home'),
            'description' => $settings['description'],
            'keyword' => '',
            'image' => ''
        ]);
    }

    public function contact()
    {
        $setting = Setting::all();
        $settings = [];

        foreach ($setting as $s) {
            $settings[$s->name] = $s->value;
        }

        return view('contact', [
            'settings' => $settings,
            'title' => __('contactus'),
            'breadcrumbs' => [
                __('contactus') => '#'
            ],
            // untuk SEO
            'title' => __('contactus'),
            'description' => __('contactus'),
            'keyword' => '',
            'image' => ''
        ]);
    }
}
