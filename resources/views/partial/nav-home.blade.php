<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
            <img src="{{asset('img/logo.png')}}" alt="">
            <!-- {{ config('app.name', 'Laravel') }} -->
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#page-top">Home</a>
                </li>
                @foreach ($pages as $p)
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#{{str_replace(' ', '-', $p->title)}}">{{$p->title}}</a>
                </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#programs">Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#donasi">Donasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#portfolio">Galeri</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#team">Team</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#artikel">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">Hubungi Kami</a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); window.location.href = '/login'">Login</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault();
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