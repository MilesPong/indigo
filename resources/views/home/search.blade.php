@extends('layouts.base')

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h1>Search: {{ $queryString }}</h1>
                @if(config('scout.driver') === 'algolia')
                    <p class="col s4 offset-s4 m2 offset-m5">
                        <object type="image/svg+xml" data="https://www.algolia.com/static_assets/images/press/downloads/search-by-algolia.svg">Your browser does not support SVGs</object>
                    </p>
                @endif
            </div>
        </div>
    @endcomponent

    <div class="container">
        @include('partials.main-content')
    </div>
@endsection