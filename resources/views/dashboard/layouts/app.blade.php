<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-color" content="#ee6e73"/>

    @include('partials.favicon')

    <title>@section('title'){{ config('app.name', 'Laravel') }}@show</title>

    <meta name="keywords" content="@section('keywords'){{ setting('keywords') }}@show">
    <meta name="description" content="@section('description'){{ setting('description') }}@show">

    <!-- Styles -->
    <link href="{{ mix('css/admin.css', 'backend') }}" rel="stylesheet">

    {{-- TODO stack is not work before push, if not using extend view --}}
    {{-- Solution 1: use section or yield instead, but still require to use extend view --}}
    {{-- Solution 2: use stack is ok while in extend view --}}
    {{--@yield('css')--}}
    @stack('css')

</head>
<body>
    <div id="app" v-cloak>
        <header>
            @include('dashboard.partials.navbar')

            @include('dashboard.partials.sidenav')
        </header>

        <main class="grey lighten-4">
            @yield('content')
        </main>

        @include('dashboard.partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js', 'backend') }}"></script>
    <script src="{{ mix('js/vendor.js', 'backend') }}"></script>
    <script src="{{ mix('js/admin.js', 'backend') }}"></script>

    @stack('js')
</body>
</html>
