<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;
use App\Http\Requests\PostCategoryRequest;

class PostCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN);
    }

    public function index(Request $request)
    {
        $sort = $request->sort ? $request->sort : 'name';
        $order = $request->order == 'ascending' ? 'asc' : 'desc';

        return PostCategory::when($request->keyword, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->keyword . '%');
        })->orderBy($sort, $order)->paginate($request->pageSize);
    }

    public function store(PostCategoryRequest $request)
    {
        return PostCategory::create($request->all());
    }

    public function update(PostCategoryRequest $request, PostCategory $postCategory)
    {
        $postCategory->update($request->all());
        return $postCategory;
    }

    public function destroy(PostCategory $postCategory)
    {
        if ($postCategory->delete()) {
            if ($postCategory->image && file_exists(public_path($postCategory->image))) {
                unlink(public_path($postCategory->image));
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
