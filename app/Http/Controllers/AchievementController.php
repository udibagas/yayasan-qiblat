<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AchievementRequest;
use App\Achievement;

class AchievementController extends Controller
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
        if ($request->ajax()) {
                $sort = $request->sort ? $request->sort : 'name_id';
                $order = $request->order == 'ascending' ? 'asc' : 'desc';

                return Achievement::when($request->keyword, function ($q) use ($request) {
                    return $q->where('name_id', 'LIKE', '%' . $request->keyword . '%')
                        ->orWhere('description_id', 'LIKE', '%' . $request->keyword . '%');
                })->orderBy($sort, $order)->paginate($request->pageSize);
            }

        // untuk frontend
        return view('Achievement.index', [
            'title' => 'Achievement Kami',
            'Achievements' => Achievement::all(),
            'breadcrumbs' => [
                'Achievement Kami' => '#'
            ],
            // untuk SEO
            'title' => 'Achievement Kami',
            'description' => 'Achievement Kami',
            'keyword' => '',
            'image' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AchievementRequest $request)
    {
        return Achievement::create($request->all());
    }

    public function show(Achievement $achievement)
    {
        return view('Achievement.show', [
            'Achievement' => $achievement,
            'title' => $achievement->name,
            'breadcrumbs' => [
                'Achievement' => url('/achievement'),
                $achievement->name => '#'
            ],
            // untuk SEO
            'title' => $achievement->name,
            'description' => $achievement->description,
            'keyword' => '',
            'image' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AchievementRequest $request, Achievement $achievement)
    {
        $achievement->update($request->all());
        return $achievement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();
        return ['message' => 'OK'];
    }

    public function getList()
    {
        return Achievement::all();
    }
}