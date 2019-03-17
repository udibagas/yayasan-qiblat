@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="programs" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="{{$program->icon}} fa-stack-1x fa-inverse"></i>
                        </span>
                        <h2 class="service-heading">{{$program->name}}</h2>
                        <p class="text-muted">{{$program->description}}</p>
                        <div>
                        </div>
                    </div>
                </div>
                <!-- TODO: list paket  -->
                <div class="card-deck mb-3 text-center">
                    @foreach ($program->packages as $p)
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-warning">
                            <h4 class="my-0 font-weight-normal">{{$p->name}}</h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($p->prices as $curr => $price)
                            <li class="list-group-item" style="font-size:2em">
                                {{number_format($price, 0, ',', '.')}} <small>{{$curr}}</small>
                            </li>
                            @endforeach
                        </ul>
                        <div class="card-body">
                            <p class="text-muted">{!! nl2br($p->description) !!}</p>
                            <a href="{{url('donation/create?package='.$p->id)}}" class="btn btn-lg btn-block btn-primary">Donasi untuk program ini</a>
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