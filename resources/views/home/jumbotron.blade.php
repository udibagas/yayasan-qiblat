@if ($slider)
<header class="masthead">
    <div class="container">
        <div class="intro-text">
            <div class="intro-heading text-uppercase">{{ $slider->title }}</div>
            <div class="intro-lead-in" style="font-style:normal;">{{ $slider->description }}</div>
            <br>
            @foreach ($slider->buttons as $b)
            <a class="btn btn-{{$b->type}} btn-xl text-uppercase" href="{{url($b->url)}}" @if (!$loop->last) style="margin-right:15px;"@endif>{{$b->label}}</a>
            @endforeach
        </div>
    </div>
</header>
@endif