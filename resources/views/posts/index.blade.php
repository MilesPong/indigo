@extends('layouts.base')

@section('content')
    @component('components.header')
        <div class="row center white-text">
            <h1 class="heading">{{ setting('heading', config('app.name')) }}</h1>
        </div>
    @endcomponent

    <div class="container">
        @include('partials.main-content')
    </div>
@endsection

@push('css')
    <link href="https://fonts.googleapis.com/css?family=Oswald:500&text={{ urlencode(setting('heading')) }}" rel="stylesheet">

    <style>
        .heading {
            font-family: 'Oswald', sans-serif;
        }
    </style>
@endpush