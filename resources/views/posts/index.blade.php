@extends('layouts.base')

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
        @include('partials.main-content')
    </div>
@endsection