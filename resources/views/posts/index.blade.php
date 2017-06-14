@extends('layouts.app')

@section('content')
    @component('components.header')
        <div class="row">
            <img src="{{ asset('images/avatar.jpg') }}" alt="" class="col s4 offset-s4 m2 offset-m5 circle responsive-img">
        </div>
        <div class="row center white-text">
            <h5>Miles Peng</h5>
        </div>
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col s12 m8">
                @include('posts._list')
            </div>
            <div class="col s12 m4">
                @include('partials.sidebar')
            </div>
            <div class="col s12 center">
                {{ $posts->links('pagination::materialize') }}
            </div>
        </div>
    </div>
@endsection