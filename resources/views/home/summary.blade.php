<section id="donasi" style="background:rgba(0,0,0,.5);padding: 30px 0;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">{{ App\User::member()->count() }}</h4>
                <p class="text-white">Donatur</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-donate fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">{{ App\Donation::selectRaw('SUM(amount) AS amount')->completed()->first()->amount }}</h4>
                <p class="text-white">Donasi</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-mosque fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">0</h4>
                <p class="text-white">Masjid</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="far fa-circle fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="service-heading">0</h4>
                <p class="text-white">Sumur</p>
            </div>
        </div>
        <br>
        <a href="{{url('/program')}}" class="btn btn-lg btn-primary btn-block" style="height:70px;line-height:50px;">DONASI SEKARANG</a>
    </div>
</section>