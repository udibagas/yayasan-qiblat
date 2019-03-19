@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="programs" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 shadow">
                    <div class="card-body text-center">
                        @if (!$program->image)
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="{{$program->icon}} fa-stack-1x fa-inverse"></i>
                        </span>
                        @else
                        <img src="{{$program->image}}" class="program-icon" alt="">
                        @endif
                        <h2 class="service-heading">{{$program->name}}</h2>
                        <p class="text-muted">{{$program->description}}</p>
                        <div>
                        </div>
                    </div>
                </div>
                <!-- TODO: list paket  -->
                <div class="card-deck mb-3">
                    @foreach ($program->packages as $p)
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-primary">
                            <h4 class="my-0 font-weight-normal text-white text-center">{{$p->name}}</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($p->prices as $curr => $price)
                            <li class="list-group-item text-right" style="font-size:2em">
                                {{number_format($price, 0, ',', '.')}}  <small>{{$curr}}</small>
                                <img src="{{asset('img/currency/'.$curr.'.jpeg')}}" alt="" style="border:1px solid #ddd;">
                            </li>
                            @endforeach
                        </ul>
                        <div class="card-body">
                            <p class="text-muted">{!! nl2br($p->description) !!}</p>
                            <a href="{{url('donation/create?package='.$p->id)}}" class="btn btn-lg btn-block btn-primary" style="border-radius:30px">
                                Donasi untuk program ini
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- TODO: galery  -->
            </div>
</section>

@if (count($program->galleries))
@include('home.gallery', ['galleries' => $program->galleries])
@endif

@endsection

@push('script')
<script>
    // setTimeout(function() {
    //     var element = document.getElementById("mainNav");
    //     element.classList.add("navbar-shrink");
    // }, 300)
</script>
@endpush 