<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostImage;

class PostImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:' . \App\User::ROLE_ADMIN);
    }

    public function index(Request $request)
    {
        return PostImage::where('post_id', $request->post_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate(['path' => 'required']);
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        return PostImage::create($input);
    }

    public function update(PostImage $postImage, Request $request)
    {
        $request->validate(['path' => 'required']);
        $postImage->update($request->all());
        return $postImage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (file_exists(public_path($request->path))) {
            unlink(public_path($request->path));
        }

        PostImage::where('path', $request->path)->delete();
        return ['message' => 'OK'];
    }

}
