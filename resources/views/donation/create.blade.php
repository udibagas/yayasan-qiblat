@extends('layouts.frontend')

@section('content')
@include('partial.breadcrumbs')

<section id="donasi" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body text-center">
                        @if (!$package->program->image)
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="{{$package->program->icon}} fa-stack-1x fa-inverse"></i>
                        </span>
                        @else
                        <img src="{{$package->program->image}}" class="program-icon" alt="">
                        @endif
                        <h2 class="service-heading">{{$package->program->name}}</h2>
                        <p class="text-muted">{{$package->program->description}}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($package->prices as $price)
                        <li class="list-group-item text-right" style="font-size:2em">
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
                    </ul>
                </div>
                <br>
            </div>
            <div class="col-md-7">
                <div class="card mb-4 shadow">
                    <div class="card-header bg-primary">
                        <h4 class="my-0 font-weight-normal text-white text-center">{{$package->name}}</h4>
                    </div>
                    @if ($package->image)
                    <img src="{{asset($package->image)}}" alt="" style="margin-bottom:20px;width:100%;">
                    @endif
                    <div class="card-body">
                        <p class="text-muted {{app()->getLocale() == 'ar' ? 'text-right' : ''}}">{!! nl2br($package->description) !!}</p>
                    </div>
                </div>
                <div class="card mb-4 shadow">
                    <div class="card-header bg-primary">
                        <h4 class="my-0 font-weight-normal text-white text-center">{{ __('donationform') }}</h4>
                    </div>
                    <div class="card-body">
                        <donate-form :paket="{{$package->id}}" label="{{ __('donatenow') }}"></donate-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
