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

    <meta name="theme-color" content="#ee6e73"/>

    @include('partials.favicon')

    <title>@section('title'){{ setting('title', config('app.name', 'Laravel')) }}@show</title>

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
        {{-- Header --}}
        <header>
            @include('admin.partials.navbar')

            @include('admin.partials.sidenav')
        </header>

        {{-- Main --}}
        <main class="grey lighten-4">
            <div class="container">
                <div class="section">
                    <div class="card-panel">

                        @yield('content')

                    </div>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        @include('admin.partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js', 'backend') }}"></script>
    <script src="{{ mix('js/vendor.js', 'backend') }}"></script>
    <script src="{{ mix('js/admin.js', 'backend') }}"></script>

    @stack('js')
</body>
</html>
