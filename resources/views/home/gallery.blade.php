<section class="bg-light" id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">{{ __('galleries') }}</h2>
                <h3 class="section-subheading text-muted">Berikut foto kegiatan program kami yang telah berjalan.</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($galleries as $g)
            <div class="col-md-4 col-sm-6 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal{{$loop->index}}">
                <div class="portfolio-hover">
                    <div class="portfolio-hover-content">
                    <i class="fas fa-plus fa-3x"></i>
                    </div>
                </div>
                <img class="img-fluid" src="{{$g->image_path}}" alt="">
                </a>
                <div class="portfolio-caption">
                <h4>{{$g->title}}</h4>
                <p class="text-muted">{{$g->description}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@foreach ($galleries as $g)
<div class="portfolio-modal modal fade" id="portfolioModal{{$loop->index}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
        <div class="lr">
            <div class="rl"></div>
        </div>
        </div>
        <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
            <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">{{$g->program->name}}</h2>
                <p class="item-intro text-muted">{{$g->program->description}}</p>
                <img class="img-fluid d-block mx-auto" src="{{$g->image_path}}" alt="">
                <h3>{{$g->title}}</h3>
                <p>{{$g->description}}</p>
                <!-- <ul class="list-inline">
                    <li>Date: January 2017</li>
                    <li>Client: Threads</li>
                    <li>Category: Illustration</li>
                </ul> -->
                <button class="btn btn-primary" data-dismiss="modal" type="button"> <i class="fas fa-times"></i> Tutup</button>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endforeach