@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="programs" style="padding:30px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">{{ __('ourprograms')}}</h2>
                <h3 class="section-subheading text-muted"></h3>
            </div>
        </div>
        <div class="row text-center">
            @foreach ($programs as $p)
            <div class="col-md-4" style="height:250px;">
                <a href="/program/{{$p->id}}" class="no-decoration-on-hover">
                    @if (!$p->image)
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="{{$p->icon}} fa-stack-1x fa-inverse"></i>
                    </span>
                    @else
                    <img src="{{$p->image}}" class="program-icon" alt="">
                    @endif
                    <h4 class="service-heading">{{$p->name}}</h4>
                    <p class="text-muted">{{$p->description}}</p>
                </a>
            </div>
            @endforeach
        </div>

        @auth
        <!-- <a href="{{url('/donation')}}" class="btn btn-lg btn-primary btn-block" style="height:70px;line-height:50px;border-radius:60px">{{ __('MYDONATION') }}</a> -->
        @endauth
    </div>
</section>

@endsection

@push('script')
<script>
    setTimeout(function() {
        var element = document.getElementById("mainNav");
        element.classList.add("navbar-shrink");
    }, 300)
</script>
@endpush 