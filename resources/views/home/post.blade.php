<section id="artikel">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">{{ __('newsnarticle')}}</h2>
                <h3 class="section-subheading text-muted">&nbsp;</h3>
            </div>
        </div>
        <div class="row mb-2">
            @foreach ($posts as $p)
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                    <img src="{{$p->image}}" alt="{{$p->title}}" style="height:180px;">
                    <div class="card-body d-flex flex-column align-items-start" style="height:180px;overflow:hidden;">
                        <!-- <strong class="d-inline-block mb-2 text-primary">World</strong> -->
                        <h4 class="mb-0"> <a class="text-dark" href="{{url('/'.$p->slug)}}">{{str_limit($p->title, 100)}}</a> </h4>
                        <div class="mb-1 text-muted">{{date('d M Y', strtotime($p->updated_at))}}</div>
                        <!-- <div class="card-text mb-auto" style="height:50px;overflow:hidden;">{!! $p->content !!}</div> -->
                        <!-- <a href="{{url('post/'.$p->id)}}">Lanjut membaca</a> -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            @if (\App\Post::active()->post()->count() > 10)
            <a href="{{url('post')}}" class="btn btn-lg btn-block btn-primary" style="border-radius:40px">{{__('readmore')}}</a>
            @endif
        </div>
    </div>
</section> 