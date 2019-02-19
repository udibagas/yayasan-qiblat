<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProgramRequest;
use App\Program;

class ProgramController extends Controller
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
            $sort = $request->sort ? $request->sort : 'name';
            $order = $request->order == 'ascending' ? 'asc' : 'desc';
    
            return Program::when($request->keyword, function ($q) use ($request) {
                return $q->where('name', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->keyword . '%');
            })->orderBy($sort, $order)->paginate($request->pageSize);
        }

        // untuk frontend
        return view('program.index', [
            'title' => 'Program Kami',
            'programs' => Program::all(),
            'breadcrumbs' => [
                'Program Kami' => '#'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        return Program::create($request->all());
    }

    public function show(Program $program)
    {
        return view('program.show', [
            'title' => $program->name,
            'program' => $program,
            'breadcrumbs' => [
                'Program' => url('/program'),
                $program->name => '#'
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
    public function update(ProgramRequest $request, Program $program)
    {
        $program->update($request->all());
        return $program;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();
        return ['message' => 'OK'];
    }

    public function getList()
    {
        return Program::all();
    }
}
