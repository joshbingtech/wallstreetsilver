<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->
    <link href="{{ asset('fonts/themify-icons/themify-icons.css') }}" rel="stylesheet">
    @notifyCss

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    @stack('css')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
</head>
<body>
    <x:notify-messages />

    <div id="app">
        <div id="content-loader">
            <div class="content-loader-container">
                <div class="content-loader-corner-top"></div>
                <div class="content-loader-corner-bottom"></div>
            </div>
            <div class="content-loader-square"></div>
        </div>
        @include('layouts.header')
        <main class="main-content py-4">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>

    <!-- JavaScript -->
    @notifyJs
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @stack('scripts')
    <script type="text/javascript" src="{{ asset('js/app.js') }}" ></script>
</body>
</html>
