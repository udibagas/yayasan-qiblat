<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/backend.js') }}" defer></script>

    <!-- Styles -->
    <link rel="icon" href="{{asset('/images/logo.png')}}">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <App />
    </div>
    <script>
    const BASE_URL = '{{url("/")}}'
    @auth
    const USER = {!! auth()->user() !!}
    @endauth
    </script>
</body>
</html>
