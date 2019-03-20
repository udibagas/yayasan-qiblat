<section id="donasi">
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">{{ __('donationachievement') }}</h2>
                <h3 class="section-subheading text-muted">{{ __('berikutlaporandonasihariini') }}</h3>
            </div>
        </div>

        <div class="row text-center">
            @foreach ($achievements as $p)
            <div class="col-md-2">
                <img src="{{$p->image}}" class="program-icon" alt="">
                <h4 class="service-heading">{{$p->name}}</h4>
                <p class="text-muted">{{$p->description}}</p>
                <h2>{{$p->achievement}}</h2>
            </div>
            @endforeach
        </div>

        <br>
        <a href="{{url('/program')}}" class="btn btn-lg btn-primary btn-block" style="border-radius:40px">{{ __('DONATENOW') }}</a>
        @auth
        <a href="{{url('/donation')}}" class="btn btn-lg btn-primary btn-block" style="border-radius:40px">{{ __('MYDONATION') }}</a>
        @endauth
    </div>
</section> 