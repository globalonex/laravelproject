<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
       <navbar app-name="{{ config('app.name', 'Laravel') }}"
       route-cart="{{ route('cart') }}"
       route-login="{{ route('login') }}"
       route-register="{{ route('register') }}"
       route-logout="{{ route('logout') }}"
       @if(Auth::user())
       route-profile="{{ route('profile') }}"
       :user="{{ Auth::user() }}"
       @else
        user=''
       @endif
       ></navbar>

        <main class="py-4 container mt-5">
            @yield('content')
        </main>
    </div>
</body>
</html>
