<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index', 'showBySlug']);
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN)->except(['show', 'index', 'showBySlug']);
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $sort = $request->sort ? $request->sort : 'title_id';
            $order = $request->order == 'ascending' ? 'asc' : 'desc';
    
            return Post::when($request->keyword, function ($q) use ($request) {
                return $q->where('title_id', 'LIKE', '%' . $request->keyword . '%');
            })->orderBy($sort, $order)->paginate($request->pageSize);
        }

        return view('post.index', [
            'posts' => Post::latest()->post()->paginate(10),
            'title' => __('newsnarticle'),
            'breadcrumbs' => [
                __('newsnarticle') => '#'
            ],
            // untuk SEO
            'title' => __('posts'),
            'description' => __('posts'),
            'keyword' => '',
            'image' => ''
        ]);
    }

    public function show(Post $post)
    {
        return view('post.show', [
            'post' => $post,
            'title' => $post->title,
            'breadcrumbs' => [
                __('newsnarticle') => url('/post'),
                $post->title => '#'
            ],
            // untuk SEO
            'title' => $post->title,
            'description' => str_limit(strip_tags($post->content), 150),
            'keyword' => '',
            'image' => ''
        ]);
    }

    public function showBySlug($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            abort(404);
        }

        return view('post.show', [
            'post' => $post,
            'title' => $post->title,
            'breadcrumbs' => [
                __('newsnarticle') => url('/post'),
                $post->title => '#'
            ],
            // untuk SEO
            'title' => $post->title,
            'description' => str_limit(strip_tags($post->content), 150),
            'keyword' => '',
            'image' => ''
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
