@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="artikel" style="padding:20px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div style="margin-bottom: 30px;">
                    <img src="{{$post->image}}" style="width:100%;">
                </div>
                <h1 class="{{app()->getLocale() == 'ar' ? 'text-right' : ''}}">{{$post->title}}</h1>
                <div class="text-muted {{app()->getLocale() == 'ar' ? 'text-right' : ''}}">{{date('d M Y', strtotime($post->updated_at))}}</div>
                <hr>
                <div class="{{app()->getLocale() == 'ar' ? 'text-right' : ''}}">{!! $post->content !!}</div>
            </div>
            <div class="col-md-5">
                @foreach(\app\Post::active()->post()->limit(5)->latest()->get() as $p)
                <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                    <img src="{{$p->image}}" alt="{{$p->title}}" style="height:120px;">
                    <div class="card-body d-flex flex-column align-items-start {{app()->getLocale() == 'ar' ? 'text-right' : ''}}" style="height:120px;overflow:hidden;">
                        <h5 class="mb-0"> <a class="text-dark" href="{{url('/'.$p->slug)}}">{{str_limit($p->title, 70)}}</a> </h5>
                        <div class="mb-1 text-muted">{{date('d M Y', strtotime($p->updated_at))}}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection 