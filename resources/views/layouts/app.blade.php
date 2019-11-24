<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/form-jeyakarthika.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"> --}}

    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        @auth
            <nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color:brown">
                <div class="container">
                    <a class="navbar-brand mr-4" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            @guest
                            @else
                                <li class="nav-item active mr-4">
                                    <a class="nav-link" href="{{ route('rezervari.index') }}">
                                        <i class="fas fa-list-ul mr-1"></i>Rezervări
                                    </a>
                                </li>
                                @if (auth()->user()->roles()->pluck( 'nume' )->contains( 'administrator' ))
                                    <li class="nav-item active mr-4">
                                        <a class="nav-link" href="{{ route('users.index') }}">
                                            <i class="fas fa-users mr-1"></i>Utilizatori
                                        </a>
                                    </li>
                                @endif
                            @endguest
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto text-white">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('auth.Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('auth.Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item active dropdown d-flex justify-content-around">
                                        @isset(auth()->user()->avatar)
                                            <img src="{{ Auth::user()->avatar }}" class="rounded-circle my-0 py-0" height="40">
                                        @endisset
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            
            <main class="py-3">
                @yield('content')
            </main>
        @endauth

        @guest
            <main class="py-3">
                @yield('content')
            </main>
        @endguest
    </div>
</body>
</html>
