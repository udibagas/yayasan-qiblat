<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/')}}">Home</a>
                </li>
                @foreach ($pages as $p)
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{url('/post/'.$p->id)}}">{{$p->title}}</a>
                </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/program')}}">Program Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/program')}}">Donasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/programGallery')}}">Galeri Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/team')}}">Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/post')}}">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/contact')}}">Hubungi Kami</a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/login')}}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/daftar')}}">Daftar</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> 