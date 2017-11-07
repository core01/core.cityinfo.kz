<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body>
<div id="app">

    <nav class="navbar has-shadow">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                    {{--<img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28">--}}
                </a>
                <div class="navbar-burger burger" data-target="navMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div id="navMenu" class="navbar-menu">
                @auth
                    <div class="navbar-start">
                        <a class="navbar-item is-tab {{ Active::checkRoute('manager') }}" href="{{ route('manager') }}">
                            @lang('nav.main')
                        </a>
                        @can('manage users')
                            <a class="navbar-item is-tab {{ Active::checkRoute('manager.users') }}"
                               href="{{ route('manager.users') }}">
                                @lang('nav.users')
                            </a>
                        @endcan
                        @can('manage company meta')
                            <a class="navbar-item is-tab {{ Active::checkRoute('manager.company.meta') }}"
                               href="{{ route('manager.company.meta') }}">
                                Описание компаний
                            </a>
                        @endcan
                    </div>
                @endauth
                <div class="navbar-end">
                    @guest



                        <a class="navbar-item" href="{{ route('login') }}">
                            @lang('auth.login')
                        </a>
                        @if(config('app.registration_enabled'))
                            <a class="navbar-item" href="{{ route('register') }}">
                                @lang('auth.register')
                            </a>
                        @endif

                        @else
                            <auth-logout :name='"{{ Auth::user()->name }}"'
                                         :logout-url='"{{ route('logout') }}"'
                                         :profile-url='"{{route('profile')}}"'
                            ></auth-logout>

                            @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="container">

        @yield('content')
    </div>
</div>
<!-- Scripts -->

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>