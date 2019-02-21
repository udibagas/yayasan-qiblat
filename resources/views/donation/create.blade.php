@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="donasi" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="{{$package->program->icon}} fa-stack-1x fa-inverse"></i>
                </span>
                <h2 class="service-heading">{{$package->program->name}}</h2>
                <p class="text-muted">{{$package->program->description}}</p>
            </div>
            <div class="col-md-8">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{$package->name}}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">Rp {{number_format($package->price, 0, ',', '.')}}</h1>
                        <p class="text-muted">{!! nl2br($package->description) !!}</p>
                        
                        <donate-button 
                        amount="{{$package->price}}" 
                        label="DONASI SEKARANG" 
                        remark="{{$package->program->name}} - {{$package->name}}"
                        package="{{$package->id}}" 
                        :flexible="{{$package->flexible_amount}}"
                        program="{{$package->program->id}}">
                        </donate-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection