@extends('layouts.auth')

@section('content')
<div class="container" style="padding-top:50px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center"> LOGIN </h3>
                    <hr>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

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
                            <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                            </button>

                            <br>

                            <a href="{{ url('/auth/google') }}" class="btn btn-outline-primary btn-block"><i class="fab fa-google"></i> Login Melalui Google</a>
                            <a href="{{ url('/auth/twitter') }}" class="btn btn-outline-primary btn-block"><i class="fab fa-twitter"></i> Login Melalui Twitter</a>
                            <a href="{{ url('/auth/facebook') }}" class="btn btn-outline-primary btn-block"><i class="fab fa-facebook-f"></i> Login Melalui Facebook</a>

                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <a class="btn btn-outline-primary btn-block" href="{{ route('register') }}">
                                        Daftar
                                    </a>
                                </div>
                                <div class="col-6">
                                     @if (Route::has('password.request'))
                                        <a class="btn btn-outline-primary btn-block" href="{{ route('password.request') }}">
                                            Lupas Password
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
