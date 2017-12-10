<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-color" content="#ee6e73" />

    @include('partials.favicon')

    <title>@section('title'){{ config('app.name', 'Laravel') }}@show</title>

    <meta name="keywords" content="@section('keywords'){{ setting('keywords') }}@show">
    <meta name="description" content="@section('description'){{ setting('description') }}@show">

    {{--<!--Import Google Icon Font-->--}}
    {{--<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    {{-- TODO stack is not work before push, if not using extend view --}}
    {{-- Solution 1: use section or yield instead, but still require to use extend view --}}
    {{-- Solution 2: use stack is ok while in extend view --}}
    {{--@yield('css')--}}
    @stack('css')

    <style>
        .btn-profile {
            position: absolute;
            left: -20%;
        }

        .post-meta ul li a {
            color: #616161 !important;
        }

        .fix-post-meta ul li a {
            color: #FFFFFF !important;
        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    {{--<div id="app">--}}
        <header>
            @include('partials.navbar')
        </header>

        <main class="grey lighten-4">
            @yield('content')
        </main>

        @include('partials.footer')

        @include('partials.fab')
    {{--</div>--}}

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>

    @stack('js')

    @include('partials.google_analytics')
</body>
</html>
