<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgramGallery;
use App\Http\Requests\ProgramGalleryRequest;

class ProgramGalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN)->except(['index']);
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $sort = $request->sort ? $request->sort : 'id';
            $order = $request->order == 'ascending' ? 'asc' : 'desc';

            return ProgramGallery::when($request->keyword, function ($q) use ($request) {
                return $q->where('title_id', 'LIKE', '%' . $request->keyword . '%')
                    ->where('description_id', 'LIKE', '%' . $request->keyword . '%');
            })->orderBy($sort, $order)->paginate($request->pageSize);
        }

        return view('programGallery.index', [
            'title' => __('galleries'),
            'galleries' => ProgramGallery::paginate(),
            'breadcrumbs' => [
                __('galleries') => '#'
            ],
            // untuk SEO
            'title' => __('galleries'),
            'description' => __('galleries'),
            'keyword' => '',
            'image' => ''
        ]);
    }

    public function store(ProgramGalleryRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return ProgramGallery::create($input);
    }

    public function update(ProgramGalleryRequest $request, ProgramGallery $programGallery)
    {
        $programGallery->update($request->all());
        return $programGallery;
    }

    public function destroy(ProgramGallery $programGallery)
    {
        if ($programGallery->delete()) {
            if ($programGallery->image && file_exists(public_path($programGallery->image))) {
                unlink(public_path($programGallery->image));
            }
        }
    }

    public function uploadImage(Request $request)
    {
        // $request->validate([
        //     'file' => 'image|size:1024|dimensions:min_width=100,min_height=100'
        // ]);

        $file = $request->file('file');
        $fileName = time() . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if (!in_array(strtolower($extension), ['png', 'jpg', 'jpeg'])) {
            return response(['message' => 'File extension not permitted'], 500);
        }

        try {
            $file->move('uploads/', $fileName);
        } catch (\Exception $e) {
            return response(['message' => 'Failed to move file'], 500);
        }

        return ['path' => '/uploads/' . $fileName];
    }
}
