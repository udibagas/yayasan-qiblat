@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="" style="padding:30px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">{{ __('contactus') }}</h2>
                <h3 class="section-subheading text-muted">{{ __('hubungikamiuntukinfolengkap') }}</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-phone fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">{{ __('phoneorwa') }}</h4>
                <p class="text-muted">{{$settings['contact_phone']}}</p>
            </div>
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">{{ __('email') }}</h4>
                <p class="text-muted">{{$settings['contact_email']}}</p>
            </div>
            <div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">{{ __('address') }}</h4>
                <p class="text-muted">
                    @if (app()->getLocale() == 'ar')
                    {{ __('myaddress') }}
                    @else
                    {!! nl2br($settings['contact_address']) !!}
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>
<iframe class="embed-responsive-item" src="{{$settings['maps_src']}}" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>

@endsection 