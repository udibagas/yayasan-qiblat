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
            <li class="nav-item">
                <a class="nav-link" href="{{url('/about')}}">Tentang Kami</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/program')}}">Program Kami</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/donation/create')}}">Donasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/programGallery')}}">Galeri Program</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/team')}}">Team</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/contact')}}">Hubungi Kami</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/post')}}">Artikel</a>
            </li>
        </ul>
        </div>
    </div>
</nav>