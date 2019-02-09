<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $sort = $request->sort ? $request->sort : 'name';
        $order = $request->order == 'ascending' ? 'asc' : 'desc';

        return Post::when($request->keyword, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%' . $request->keyword . '%');
        })->orderBy($sort, $order)->paginate($request->pageSize);
    }

    public function store(PostRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return Post::create($input);
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());
        return $post;
    }

    public function destroy(Post $post)
    {
        if ($post->delete()) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
        }
    }
}
