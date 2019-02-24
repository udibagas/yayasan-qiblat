<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN)->except(['show', 'index']);
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $sort = $request->sort ? $request->sort : 'name';
            $order = $request->order == 'ascending' ? 'asc' : 'desc';
    
            return Post::when($request->keyword, function ($q) use ($request) {
                return $q->where('name', 'LIKE', '%' . $request->keyword . '%');
            })->orderBy($sort, $order)->paginate($request->pageSize);
        }

        return view('post.index', [
            'posts' => Post::latest()->post()->paginate(10),
            'title' => 'Artikel',
            'breadcrumbs' => [
                'Artikel' => '#'
            ]
        ]);
    }

    public function show(Post $post)
    {
        return view('post.show', [
            'post' => $post,
            'title' => $post->title,
            'breadcrumbs' => [
                'Artikel' => url('/post'),
                $post->title => '#'
            ]
        ]);
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
