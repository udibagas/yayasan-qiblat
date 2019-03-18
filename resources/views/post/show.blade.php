@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="artikel" style="padding:20px 0;">
    <div class="container">
        <div style="max-height: 500px;overflow:hidden;margin-bottom: 30px;">
            <img src="{{$post->image}}" style="width:100%;">
        </div>
        <h1>{{$post->title}}</h1>
        <div class="text-muted">{{date('d M Y', strtotime($post->updated_at))}}</div>
        <hr>
        <div>{!! $post->content !!}</div>
    </div>
</section>

@endsection 