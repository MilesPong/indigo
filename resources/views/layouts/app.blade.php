<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{--<!--Import Google Icon Font-->--}}
    {{--<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    {{-- TODO sticky footer in app.css--}}
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

        .post-card .card-content {
            padding-bottom: 0
        }

        .post-card .post-meta {
            margin-top: 0;
        }

        .post-meta ul li {
            display: inline-block;
            margin-right: 16px
        }

        .post-meta ul li i {
            vertical-align: middle;
            margin-right: 10px
        }

        .post-card .excerpt {
            /*font-size: 1.22rem;*/
        }

        .post-card .post-tag {
            padding: 12px 24px;
        }

        .post-card .post-tag i {
            vertical-align: middle;
            margin-right: 10px
        }

        .search-form .row {
            margin-bottom: 0;
        }

        .search-form .input-field {
            width: 100%;
        }

        .tag-list {
            padding: 10px;
        }
        .badge-tag {
            padding: 3px 7px;
            font-size: 12px;
            vertical-align: middle;
            margin-left: 5px;
        }
    </style>

    {{-- TODO stack is not work before push, if not using extend view --}}
    {{-- Solution 1: use section or yield instead, but still require to use extend view --}}
    {{-- Solution 2: use stack is ok while in extend view --}}
    {{--@yield('css')--}}
    @stack('css')

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

        <main>
            @yield('content')
        </main>

        @include('partials.footer')

        @include('partials.fab')
    {{--</div>--}}

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>

    @stack('js')
</body>
</html>
