<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarouselButton;

class CarouselButtonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN);
    }

    public function destroy(CarouselButton $carouselButton) 
    {
        $carouselButton->delete();
        return ['message' => 'OK'];
    }
}
