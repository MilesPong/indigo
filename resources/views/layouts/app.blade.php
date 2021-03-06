<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-color" content="#ee6e73" />

    @include('partials.favicon')

    <title>@section('title'){{ setting('title', config('app.name', 'Laravel')) }}@show</title>

    <meta name="keywords" content="@section('keywords'){{ setting('keywords') }}@show">
    <meta name="description" content="@section('description'){{ setting('description') }}@show">

    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'frontend') }}" rel="stylesheet">

    {{-- TODO stack is not work before push, if not using extend view --}}
    {{-- Solution 1: use section or yield instead, but still require to use extend view --}}
    {{-- Solution 2: use stack is ok while in extend view --}}
    {{--@yield('css')--}}
    @stack('css')

    @include('feed::links')

</head>
<body>
    <div id="app" v-cloak>
        @yield('app_content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js', 'frontend') }}"></script>
    <script src="{{ mix('js/vendor.js', 'frontend') }}"></script>
    <script src="{{ mix('js/app.js', 'frontend') }}"></script>

    @stack('js')

    @include('partials.google_analytics')
</body>
</html>
