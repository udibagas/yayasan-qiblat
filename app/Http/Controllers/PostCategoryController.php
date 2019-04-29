<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostCategory;
use App\Http\Requests\PostCategoryRequest;

class PostCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['showBySlug']);
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN)->except(['showBySlug']);
    }

    public function index(Request $request)
    {
        return PostCategory::where('parent_id', null)
        ->when($request->keyword, function ($q) use ($request) {
            return $q->where('name_id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('description_id', 'LIKE', '%' . $request->keyword . '%');
        })->get();
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

    public function getList()
    {
        return PostCategory::all();
    }

    public function showBySlug($slug)
    {
        $category = PostCategory::where('slug_' . app()->getLocale(), $slug)->first();

        if (! $category) {
            abort(404);
        }

        return view('post.index', [
            'posts' => Post::where('post_category_id', $category->id)->latest()->post()->paginate(10),
            'title' => $category->name,
            'breadcrumbs' => [
                __('newsnarticle') => url('/post'),
                $category->name => '#'
            ],
            // untuk SEO
            'title' => $category->name,
            'description' => $category->description,
            'keyword' => '',
            'image' => $category->image
        ]);
    }
}
