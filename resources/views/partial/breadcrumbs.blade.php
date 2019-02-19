<div style="padding:40px 0;border-bottom: 1px solid #ddd;background-color:#fefefe;margin-top:52px;">
    <div class="container">
        <h2>{{$title}}</h2>
        <a href="{{url('/')}}">Home</a> 
        @foreach ($breadcrumbs as $label => $link)
        <span style="margin:0 5px;">/</span> @if (!$loop->last) <a href="{{$link}}">{{$label}}</a> @else {{$label}} @endif
        @endforeach
    </div>
</div>