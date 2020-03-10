<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset('img/logo.png')}}" alt="" style="height:40px">
            {{-- مؤسسة قبلة --}}
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                @guest
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{url('/login')}}">{{ __('login') }}</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{url('/daftar')}}">{{ __('register') }}</a>
                </li> -->
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link" href="{{route('contact', app()->getLocale())}}">{{ __('contactus') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('post', app()->getLocale())}}">{{ __('posts') }}</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{url('/programGallery')}}">{{ __('gallery') }}</a>
                </li> -->
                @foreach ($categories as $c)
                <li class="nav-item dropdown">
                    <a id="navbarDropdown-{{$loop->index}}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{$c->name}} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown-{{$loop->index}}">
                        @foreach ($c->children as $c1)
                        <a class="dropdown-item" href="{{url('/category/'.$c1->slug)}}">{{$c1->name}}</a>
                        @endforeach
                    </div>

                </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link" href="{{route('program', app()->getLocale())}}">{{ __('programs') }}</a>
                </li>
                @foreach ($pages as $p)
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{url('/'.$p->slug)}}">{{$p->title}}</a>
                </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/')}}">{{ __('home') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="{{ asset('/img/'.app()->getLocale().'.png')}}" alt="{{ app()->getLocale() }}" style="height:14px;"> <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), 'id') }}"><img src="{{ asset('/img/id.png')}}" alt="ID" style="height:14px;margin-right:5px">Bahasa Indonesia</a>
                        <a class="dropdown-item" href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), 'en') }}"><img src="{{ asset('/img/en.png')}}" alt="EN" style="height:14px;margin-right:5px">English</a>
                        <a class="dropdown-item" href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), 'ar') }}"><img src="{{ asset('/img/ar.png')}}" alt="AR" style="height:14px;margin-right:5px">العربية</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
