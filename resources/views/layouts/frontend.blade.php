<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@if (app()->getLocale() == 'id') Yayasan Qiblat @elseif (app()->getLocale() == 'ar') مؤسسة قبلة @else Qiblat Foundation @endif | {{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="image_src" href="" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$title}}" />
    <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}" />
    <meta property="og:description" content="{{$description}}" />
    <meta property="og:image" content="{{$image}}" />
    <!-- for Twitter -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{$title}}" />
    <meta name="twitter:description" content="{{$description}}" />
    <meta name="twitter:image" content="{{$image}}" />
    <meta name="author" content="{{ config('app.name', 'Laravel') }}" />
    <meta name="description" content="{{$description}}" />
    <meta name="keyword" content="{{$keyword}}" />
    <meta name="copyright" content="Copyright {{date('Y')}} by {{ config('app.name', 'Laravel') }}" />
    <meta name="language" content="id" />
    <meta name="distribution" content="Global" />
    <meta name="rating" content="General" />
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <meta name="revisit-after" content="1 days" />
    <meta name="expires" content="never" />
    <meta name="dc.title" content="{{ config('app.name', 'Laravel') }}" />
    <meta name="dc.creator.e-mail" content="udibagas@gmail.com" />
    <meta name="dc.creator.name" content="BeningJaya-Aquatic" />
    <meta name="dc.creator.website" content="{{ config('app.url') }}" />
    <meta name="tgn.name" content="Jakarta" />
    <meta name="tgn.nation" content="Indonesia" />

    <!-- Custom fonts for this template -->
    <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="icon" href="{{ asset('img/logo-qiblat-square.ico') }}">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    @if (app()->getLocale() == 'ar')
    <style>
        body,
            #mainNav .navbar-nav .nav-item .nav-link,
            h1, h2, h3, h4, h5, h6,
            #mainNav .navbar-brand,
            .btn {
                font-family: HacenLinerScreen;
            }
    </style>
    @endif

    <style>
        /* @media (min-width: 992px) {
            #mainNav.navbar-shrink {
                background-color: #e6e7e9;
            }
        }

        #mainNav .navbar-brand {
            color: #0EAAA2;
            font-size: 200%;
        } */

        @media (max-width: 480px) {
            /* #mainNav {
                background-color: #e6e7e9;
            } */

            .carousel.slide {
                margin-top: 66px;
            }
            .navbar-brand {
                display: block;
                margin: 0 auto;
            }
        }
    </style>

    <meta name="google-site-verification" content="YV7U65FEOqQ-YcBG9Or4HxTfS0fQA4uaDadbvYrw1tc" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136632642-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-136632642-1');
    </script>
</head>

<body id="page-top">
    <div id="app">
        @if (url()->current() == url('home') || url()->current() == url('/'))
        @if (app()->getLocale() == 'ar')
        @include('partial.nav-home-ar')
        @else
        @include('partial.nav-home')
        @endif
        @else
        @if (app()->getLocale() == 'ar')
        @include('partial.nav-ar')
        @else
        @include('partial.nav')
        @endif
        @endif

        @yield('content')
        @include('partial.footer')

        <message-form phone="+6285880002900" locale="{{app()->getLocale()}}"></message-form>
    </div>
</body>
<script>
    const BASE_URL = '{{url("/")}}'
    const LOCALE = '{{ app()->getLocale() }}'
    @auth
    const USER = {!! auth()->user() !!}
    @endauth
</script>
<script src="{{ asset('js/frontend.js') }}"></script>
<script src="{{ asset('js/xendit.min.js') }}"></script>
{{-- <script type="text/javascript" src="https://js.xendit.co/v1/xendit.min.js"></script> --}}
<script type="text/javascript">
	Xendit.setPublishableKey('xnd_public_production_OImGfL8g0uOtncU7LbJOTDWQN9GgqNV9lnfkRxn9WfW8LWiCgJ1hg');
	// Xendit.setPublishableKey('xnd_public_development_P4qBfL8g0uOtncU7LbJOTDWQN9GgqNV9lnfkRxn9WfW8LWiCgJ1hg');
</script>
@stack('script')

</html>
