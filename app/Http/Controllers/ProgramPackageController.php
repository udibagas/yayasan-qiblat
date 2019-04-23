<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProgramPackageRequest;
use App\ProgramPackage;
use App\ProgramPackagePrice;

class ProgramPackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN)->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // untuk backend
        if ($request->ajax())
        {
            $sort = $request->sort ? $request->sort : 'name_id';
            $order = $request->order == 'ascending' ? 'asc' : 'desc';
    
            return ProgramPackage::when($request->keyword, function ($q) use ($request) {
                return $q->where('name_id', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('description_id', 'LIKE', '%' . $request->keyword . '%');
            })->orderBy($sort, $order)->paginate($request->pageSize);
        }

        // untuk frontend
        return view('programPackage.index', [
            'title' => 'ProgramPackage Kami',
            'programPackages' => ProgramPackage::all(),
            'breadcrumbs' => [
                'ProgramPackage Kami' => '#'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramPackageRequest $request)
    {
        $package = ProgramPackage::create($request->all());
        
        foreach ($request->prices as $currency => $price) {
            if ($price == null) {
                continue;
            }

            $package->prices()->create([
                'currency_rate_id' => $currency,
                'price' => $price
            ]);
        }

        return $package;
    }

    public function show(Request $request, ProgramPackage $programPackage)
    {
        if ($request->ajax()) {
            return $programPackage;
        }

        return view('programPackage.show', [
            'title' => $programPackage->name,
            'programPackage' => $programPackage,
            'breadcrumbs' => [
                'ProgramPackage' => url('/programPackage'),
                $programPackage->name => '#'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramPackageRequest $request, ProgramPackage $programPackage)
    {
        $programPackage->update($request->all());

        foreach ($request->prices as $currency => $price) {
            $packagePrice = ProgramPackagePrice::where('program_package_id', $programPackage->id)
                        ->where('currency_rate_id', $currency)
                        ->first();
            
            if ( $packagePrice) {
                $packagePrice->update(['price' => $price]);
            }
            
            else {
                if ($price == null || is_array($price)) {
                    continue;
                }

                $programPackage->prices()->create([
                    'currency_rate_id' => $currency,
                    'price' => $price
                ]);
            }
        }

        return $programPackage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramPackage $programPackage)
    {
        $programPackage->delete();
        return ['message' => 'OK'];
    }

    public function getList()
    {
        return ProgramPackage::all();
    }
}
