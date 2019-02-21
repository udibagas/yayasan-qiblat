@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="programs" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="{{$program->icon}} fa-stack-1x fa-inverse"></i>
                </span>
                <h2 class="service-heading">{{$program->name}}</h2>
                <p class="text-muted">{{$program->description}}</p>
            </div>
        </div>

        <br>
        <!-- TODO: list paket  -->
        <div class="card-deck mb-3 text-center">
            @foreach ($program->packages as $p)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-warning">
                    <h4 class="my-0 font-weight-normal">{{$p->name}}</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">Rp {{number_format($p->price, 0, ',', '.')}}</h1>
                    <p class="text-muted">{!! nl2br($p->description) !!}</p>
                    <!-- <ul class="list-unstyled mt-3 mb-4">
                        <li>10 users included</li>
                        <li>2 GB of storage</li>
                        <li>Email support</li>
                        <li>Help center access</li>
                    </ul> -->
                    <a href="{{url('donation/create?package='.$p->id)}}" class="btn btn-lg btn-block btn-primary">Donasi untuk program ini</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- TODO: galery  -->
    </div>
</section>

@endsection

@push('script')
<script>
// setTimeout(function() {
//     var element = document.getElementById("mainNav");
//     element.classList.add("navbar-shrink");
// }, 300)
</script>
@endpush