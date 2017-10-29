<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=cyrillic" rel="stylesheet">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', 'Open Sans', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ route('manager') }}">@lang('content.dashboard')</a>
                @else
                    <a href="{{ route('login') }}">@lang('auth.login')</a>
                    @if(config('registration_enabled'))
                        <a href="{{ route('register') }}">@lang('auth.register')</a>
                    @endif

                    @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            {{ config('app.name', 'Laravel') }}
        </div>

        <div class="links">
            <a href="https://cityinfo.kz">@lang('nav.search')</a>
            <a href="https://cityinfo.kz/exchange/">@lang('nav.exchange_rates')</a>
            <a href="https://cityinfo.kz/gasoline-prices/">@lang('nav.fuel_prices')</a>
            <a href="https://www.cityinfo.kz/atms.html">@lang('nav.atms')</a>
        </div>
    </div>
</div>
</body>
</html>
