@extends('layouts.frontend')

@section('content')
<!-- Header -->
    @include('home.jumbotron')

    <!-- Program -->
    @include('home.program')

    <!-- Summary -->
    @include('home.summary')

    <!-- Gallery -->
    @include('home.gallery')

    <!-- Team -->
    @if (count($team) > 0)
    @include('home.team')
    @endif
    
@endsection
