<div id="carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach ($sliders as $c)
        <li data-target="#carousel" data-slide-to="{{$loop->index}}" class="@if ($loop->first) active @endif"></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach ($sliders as $c)
        <div class="carousel-item @if ($loop->first) active @endif" style="min-height:300px">
            <img src="{{$c->image}}" class="d-block w-100" alt="{{$c->title}}">
            <div class="carousel-caption d-md-block">
                <h2>{{$c->title}}</h2>
                <p>{{$c->description}}</p>

                @foreach ($c->buttons as $b)
                <a class="btn btn-{{$b->type}} text-uppercase mr-auto" style="margin-bottom:15px" href="{{url($b->url)}}">{{$b->label}}</a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>