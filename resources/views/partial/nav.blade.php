<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset('img/logo.png')}}" alt="">
            <!-- {{ config('app.name', 'Laravel') }} -->
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/')}}">{{ __('home') }}</a>
                </li>
                @foreach ($pages as $p)
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{url('/'.$p->slug)}}">{{$p->title}}</a>
                </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/program')}}">{{ __('programs') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/program')}}">{{ __('donation') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/programGallery')}}">{{ __('gallery') }}</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{url('/team')}}">Team</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/post')}}">{{ __('posts') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/contact')}}">{{ __('contactus') }}</a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/login')}}">{{ __('login') }}</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{url('/daftar')}}">{{ __('register') }}</a>
                </li> -->
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
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="{{ asset('/img/'.app()->getLocale().'.png')}}" alt="{{ app()->getLocale() }}" style="height:14px;"> <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('locale/id') }}"><img src="{{ asset('/img/id.png')}}" alt="ID" style="height:14px;margin-right:5px">Bahasa Indonesia</a>
                        <a class="dropdown-item" href="{{ url('locale/en') }}"><img src="{{ asset('/img/en.png')}}" alt="EN" style="height:14px;margin-right:5px">English</a>
                        <a class="dropdown-item" href="{{ url('locale/ar') }}"><img src="{{ asset('/img/ar.png')}}" alt="ID" style="height:14px;margin-right:5px">العربية</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav> 