@foreach ($pages as $p)
<section id="{{str_replace(' ', '-', $p->title)}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">{{$p->title}}</h2>
                <h3 class="section-subheading text-muted">&nbsp;</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                @if ($p->image)
                <img src="{{$p->image}}" alt="{{$p->title}}" style="width:100%">
                @endif
            </div>
            <div class="col-md-8">
                {!! $p->content !!}
            </div>
        </div>
    </div>
</section>
@endforeach 