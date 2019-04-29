<section id="portfolio">
    <div class="row">
        @foreach ($images as $g)
        <div class="col-md-4 col-sm-6 portfolio-item">
            <a class="portfolio-link" data-toggle="modal" href="#portfolioModal{{$loop->index}}">
                <div class="portfolio-hover">
                    <div class="portfolio-hover-content">
                        <i class="fas fa-plus fa-3x"></i>
                    </div>
                </div>
                <img class="img-fluid" src="{{$g->path}}" alt="">
            </a>
        </div>
        @endforeach
    </div>
</section>

@foreach ($images as $g)
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
                            <img class="img-fluid d-block mx-auto" src="{{$g->path}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach