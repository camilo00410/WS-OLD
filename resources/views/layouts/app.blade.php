<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

<style>
    .nav-item {
        margin-left: 40px;
    }
</style>

    @if (url()->current() != 'http://14.skill17.com/KR_JS-PHP_A/login')
        asdf
    @else
        else
    @endif

    <div id="app">
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('event.index') }}">Event Platform</a>
            <ul class="navbar-nav px-3" style="flex-direction: row;">
            @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
            @else
                <li class="nav-item">
                    <a href="#" class="nav-link">{{ Auth::user()->slug }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('event.index') }}" class="nav-link">Manage events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        Sign out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
            </ul>
        </nav>

        @if (\Session::has('messageType') && \Session::has('message'))
            <div class="container mt-5 pt-5" style="position:relative; z-index: 1001;">
                <div class="alert alert-{{ \Session::get('messageType') }}">
                    {{ \Session::get('message') }}
                </div>
            </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
