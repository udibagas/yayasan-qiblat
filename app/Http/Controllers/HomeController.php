<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Team;
use App\Carousel;
use App\Program;

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
            'programs' => Program::all()
        ]);
    }
}
