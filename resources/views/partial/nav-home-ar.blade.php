<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
            <img src="{{asset('img/logo.png')}}" alt="" style="height:60px">
            <!-- {{ config('app.name', 'Laravel') }} -->
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); window.location.href = '/login'">{{ __('login') }}</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">{{ __('contactus') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#artikel">{{ __('posts') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#portfolio">{{ __('gallery') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onClick="window.open('http://keblah.com/index.php?action=picture/category', '_blank')">{{ __('Lihat Masjid Anda') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#donasi">{{ __('donation') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#programs">{{ __('program') }}</a>
                </li>
                @foreach ($pages as $p)
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#{{str_replace(' ', '-', $p->title)}}">{{$p->title}}</a>
                </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#page-top">{{ __('home') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="{{ asset('/img/'.app()->getLocale().'.png')}}" alt="{{ app()->getLocale() }}" style="height:14px;"> <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English', 'ar' => 'العربية'] as $lang => $desc)
                        <a class="dropdown-item" onClick="window.location.href = '{{url('locale/'.$lang)}}'" href="#"><img src="{{ asset('/img/'.$lang.'.png')}}" alt="{{$lang}}" style="height:14px;margin-right:5px">{{$desc}}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav> 