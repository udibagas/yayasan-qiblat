@foreach ($pages as $p)
<section id="{{str_replace(' ', '-', $p->title)}}">
    <div class="container">
        <h2 class="section-heading text-uppercase text-center">{{$p->title}}</h2>
        <h3 class="section-subheading text-muted">&nbsp;</h3>
        {!! $p->content !!}
    </div>
</section>
@endforeach
