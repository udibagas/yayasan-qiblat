<section id="programs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">PROGRAM KAMI</h2>
                <h3 class="section-subheading text-muted">Apa saja program kami?</h3>
            </div>
        </div>
        <div class="row text-center">
            @foreach ($programs as $p)
            <div class="col-md-4" style="height:250px;">
                <a href="/program/{{$p->id}}" class="no-decoration-on-hover">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="{{$p->icon}} fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">{{$p->name}}</h4>
                    <p class="text-muted">{{$p->description}}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>