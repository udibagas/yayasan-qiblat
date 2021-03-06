<div style="padding:40px 0;border-bottom: 1px solid #ddd;background-color:#fefefe;margin-top:52px;">
    <div class="container {{app()->getLocale() == 'ar' ? 'text-right' : ''}}">
        <h2>{{$title}}</h2>
        <a href="{{url('/')}}">{{ __('home') }}</a>
        @foreach ($breadcrumbs as $label => $link)
        <span style="margin:0 5px;">/</span> @if (!$loop->last) <a href="{{$link}}">{{$label}}</a> @else {{$label}} @endif
        @endforeach
    </div>
</div>
