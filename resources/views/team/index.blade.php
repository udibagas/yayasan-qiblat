@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')
<section id="team" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Team Kami</h2>
                <h3 class="section-subheading text-muted">Team yang telah banyak berkontribusi untuk yayasan kami</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($team as $t)
            <div class="col-sm-4">
                <div class="team-member">
                    <img class="mx-auto rounded-circle" src="{{$t->image_path}}" alt="">
                    <h4>{{$t->name}}</h4>
                    <p class="text-muted">{{$t->description}}</p>
                    <!-- <ul class="list-inline social-buttons">
                        <li class="list-inline-item">
                        <a href="#">
                            <i class="fab fa-twitter"></i>
                        </a>
                        </li>
                        <li class="list-inline-item">
                        <a href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        </li>
                        <li class="list-inline-item">
                        <a href="#">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        </li>
                    </ul> -->
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection