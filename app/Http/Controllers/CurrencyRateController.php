<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CurrencyRate;

class CurrencyRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN)->except(['index']);
    }

    public function index()
    {
        return CurrencyRate::orderBy('currency', 'asc')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'currency' => 'required',
            'description' => 'required',
            'rate' => 'required|numeric',
        ]);

        return CurrencyRate::create($request->all());
    }

    public function update(CurrencyRate $currencyRate, Request $request)
    {
        $request->validate([
            'currency' => 'required',
            'description' => 'required',
            'rate' => 'required|numeric',
        ]);

        $currencyRate->update($request->all());

        return $currencyRate;
    }

    public function destroy(CurrencyRate $currencyRate)
    {
        $currencyRate->delete();
        return ['message' => 'OK'];
    }

}
