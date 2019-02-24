@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="artikel" style="padding:20px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="{{$post->image}}" style="width:100%;margin-bottom: 30px;">
            </div>
            <div class="col-md-8">
                <h1>{{$post->title}}</h1>
                <div class="text-muted">{{date('d M Y', strtotime($post->updated_at))}}</div>
                <hr>
                <div>{!! $post->content !!}</div>
            </div>
        </div>
    </div>
</section>

@endsection 