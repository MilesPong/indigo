@extends('layouts.app')

@section('app_content')
    <header>
        @include('partials.navbar')

        @include('partials.sidenav')
    </header>

    <main class="grey lighten-4">
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.fab')
@endsection