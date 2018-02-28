@extends('layouts.base')

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h1>Search: {{ $queryString }}</h1>
            </div>
        </div>
    @endcomponent

    <div class="container">
        @include('partials.main-content')
    </div>
@endsection