@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="donasi" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body text-center">
                        @if (!$package->program->image)
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="{{$package->program->icon}} fa-stack-1x fa-inverse"></i>
                        </span>
                        @else
                        <img src="{{$package->program->image}}" class="program-icon" alt="">
                        @endif
                        <h2 class="service-heading">{{$package->program->name}}</h2>
                        <p class="text-muted">{{$package->program->description}}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($package->prices as $curr => $price)
                        <li class="list-group-item text-right" style="font-size:2em">
                            {{number_format($price, 0, ',', '.')}} <small>{{$curr}}</small>
                            <img src="{{asset('img/currency/'.$curr.'.jpeg')}}" alt="" style="border:1px solid #ddd;">
                        </li>
                        @endforeach
                    </ul>
                </div>
                <br>
            </div>
            <div class="col-md-7">
                <div class="card mb-4 shadow">
                    <div class="card-header bg-primary">
                        <h4 class="my-0 font-weight-normal text-white">{{$package->name}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{!! nl2br($package->description) !!}</p>
                    </div>
                </div>
                <div class="card mb-4 shadow">
                    <div class="card-header bg-primary">
                        <h4 class="my-0 font-weight-normal text-white">FORM DONASI</h4>
                    </div>
                    <div class="card-body">
                        <donate-button :paket="{{$package->id}}" label="{{ __('donatenow') }}"></donate-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection 