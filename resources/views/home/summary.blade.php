<section id="donasi">
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Laporan Donasi</h2>
                <h3 class="section-subheading text-muted">Berikut adalah laporan donasi yang sudah masuk sampai hari ini</h3>
            </div>
        </div>

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
        @auth
        <a href="{{url('/donation')}}" class="btn btn-lg btn-primary btn-block" style="height:70px;line-height:50px;">LIHAT DONASI SAYA</a>
        @endauth
    </div>
</section> 