<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CarouselRequest;
use App\Carousel;
use App\CarouselButton;

class CarouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->sort ? $request->sort : 'title_id';
        $order = $request->order == 'ascending' ? 'asc' : 'desc';

        return Carousel::when($request->keyword, function ($q) use ($request) {
            return $q->where('title_id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('description_id', 'LIKE', '%' . $request->keyword . '%');
        })->when($request->status, function ($q) use ($request) {
            return $q->whereIn('status', $request->status);
        })->orderBy($sort, $order)->paginate($request->pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarouselRequest $request)
    {
        $carousel = Carousel::create($request->all());
        $carousel->buttons()->createMany($request->buttons);
        return $carousel;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Carousel $carousel)
    {
        return $carousel;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarouselRequest $request, Carousel $carousel)
    {
        $carousel->update($request->all());
        
        foreach ($request->buttons as $i) {
            if (isset($i['id'])) {
                CarouselButton::find($i['id'])->update($i);
            } else {
                $carousel->buttons()->create($i);
            }
        }

        return $carousel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carousel $carousel)
    {
        if ($carousel->delete()) {
            if ($carousel->image && file_exists(public_path($carousel->image))) {
                unlink(public_path($carousel->image));
            }
        }

        return ['message' => 'OK'];
    }
}
