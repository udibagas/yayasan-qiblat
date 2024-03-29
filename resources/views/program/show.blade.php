@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="programs" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 shadow">
                    <div class="card-body text-center">
                        @if (!$program->image)
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="{{$program->icon}} fa-stack-1x fa-inverse"></i>
                        </span>
                        @else
                        <img src="{{$program->image}}" class="program-icon" alt="">
                        @endif
                        <h2 class="service-heading">{{$program->name}}</h2>
                        <p class="text-muted">{{$program->description}}</p>
                    </div>
                </div>

                <div class="card-deck mb-3">
                    @foreach ($program->packages as $p)
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-primary">
                            <h4 class="my-0 font-weight-normal text-white text-center">{{$p->name}}</h4>
                        </div>
                        @if ($p->image)
                        <img src="{{asset($p->image)}}" alt="" style="margin-bottom:20px;width:100%">
                        @endif
                        <div class="card-body">
                            <p class="text-muted {{app()->getLocale() == 'ar' ? 'text-right' : ''}}">{!! nl2br($p->description) !!}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($p->prices as $price)
                            <li class="list-group-item text-right" style="font-size:2em;">
                                {{-- @if (app()->getLocale() == 'ar')
                                {{str_replace(
                                    ['0','1','2','3','4','5','6','7','8','9'],
                                    ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],
                                    number_format($price->price, 2)
                                )}}
                                @else
                                {{number_format($price->price, 2, ',', '.')}}
                                @endif --}}
                                <small style="display:inline-block;">{{app()->getLocale() == 'ar' ? $price->currency->description : $price->currency->currency}}</small>
                                @php
                                    $decimal = 1;
                                    if (count(explode('.', $price->price)) == 2 && (int) explode('.', $price->price)[1] == 0) {
                                        $decimal = 0;
                                    }
                                @endphp
                                {{number_format($price->price, $decimal, '.', ',')}}
                                @if ($price->currency->flag_image)
                                <img src="{{asset($price->currency->flag_image)}}" alt="" style="border:1px solid #ddd;width:50px;height:30px;">
                                @endif
                            </li>
                            @endforeach
                            <li class="list-group-item">
                                <a href="{{url('donation/create?package='.$p->id)}}" class="btn btn-lg btn-block btn-primary" style="border-radius:30px">
                                    {{__('Donasi untuk program ini')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- @if (count($program->galleries))
@include('home.gallery', ['galleries' => $program->galleries])
@endif --}}

@endsection
