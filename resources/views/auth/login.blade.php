@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('auth.Login') }}</div>

                <div class="card-body pb-0">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <a href="{{url('/login/google')}}" class="btn btn-danger btn-block d-flex">
                                    <div class="d-inline-flex align-self-center">
                                        <i class="fab fa-google fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        {{ __('auth.Login with Google') }}
                                    </div>
                                </a>
                                <a href="{{url('/login/facebook')}}" class="btn btn-primary btn-block d-flex">
                                    <div class="d-inline-flex align-self-center">
                                        <i class="fab fa-facebook-f fa-lg p-1"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        {{ __('auth.Login with Facebook') }}
                                    </div>
                                </a>
                                <div style="width: 100%; height: 15px; text-align: center" class="my-3 border-bottom border-black-50">
                                    <span style="font-size: 1.3em; background-color: white; padding: 0 10px;" class="text-black-50">
                                        sau <!--Padding is optional-->
                                    </span>
                                </div>

                            </div>
                        </div>


                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}

                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="{{ __('auth.E-Mail Address') }}"
                                    >
                                </div>

                                @error('email')
                                    <span class="text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}

                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend2"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                                        placeholder="{{ __('auth.Password') }}"
                                    >
                                </div>

                                @error('password')
                                    <span class="text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block mb-2">
                                    {{ __('auth.Login') }}
                                </button>

                                <div class="d-flex justify-content-between my-0">
                                    <div class="form-check d-inline-block">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('auth.Remember Me') }}
                                        </label>
                                    </div>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link p-0 m-0 border-0" href="{{ route('password.request') }}">
                                                {{ __('auth.Forgot Your Password?') }}
                                            </a>
                                        @endif
                                </div>

                            </div>
                        </div>

                        @if (Route::has('register'))
                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <hr>
                                    Nu ai cont? 
                                    <a class="" href="{{ route('register') }}">Înregistrează-te</a>
                                </div>
                            </div>
                        @endif
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
