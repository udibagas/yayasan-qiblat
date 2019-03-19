@extends('layouts.auth')

@section('content')
<div class="container" style="padding-top:100px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body text-center">
                    <img src="{{asset('img/logo.png')}}" alt="" style="width:100%;margin-bottom:20px">
                    <!-- <h3 class="text-center"> {{__('LOGIN')}} </h3> -->
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input id="email" placeholder="{{__('email')}}" type="email" class="input-lg form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password" placeholder="{{__('password')}}" type="password" class="input-lg form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <!-- <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                {{ __('LOGIN') }}
                            </button>

                            <br>

                            <a href="{{ url('/auth/google') }}" class="btn btn-outline-primary btn-block"><i class="fab fa-google"></i> {{__('loginwith')}} Google</a>
                            <a href="{{ url('/auth/twitter') }}" class="btn btn-outline-primary btn-block"><i class="fab fa-twitter"></i> {{__('loginwith')}} Twitter</a>
                            <a href="{{ url('/auth/facebook') }}" class="btn btn-outline-primary btn-block"><i class="fab fa-facebook-f"></i> {{__('loginwith')}} Facebook</a>

                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <a class="btn btn-outline-primary btn-block" href="{{ route('register') }}">
                                        {{__('register')}}
                                    </a>
                                </div>
                                <div class="col-6">
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-outline-primary btn-block" href="{{ route('password.request') }}">
                                        {{__('forgotpassword')}}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 