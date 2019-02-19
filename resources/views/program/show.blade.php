@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="programs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">PROGRAM KAMI</h2>
                <h3 class="section-subheading text-muted">Apa saja program kami?</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4" style="height:250px;">
                <a href="/program/{{$program->id}}" class="no-decoration-on-hover">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="{{$program->icon}} fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">{{$program->name}}</h4>
                    <p class="text-muted">{{$program->description}}</p>
                </a>
            </div>
        </div>
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