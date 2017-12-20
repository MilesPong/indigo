@extends('layouts.base')

@section('title')
    {{ $tag->name }} | @parent
@endsection

@section('keywords'){{ $tag->name }}@endsection
@section('description'){{ $tag->description }}@endsection

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h2>Tag: {{ $tag->name }}</h2>
                <p class="flow-text">{{ $tag->description }}</p>
            </div>
        </div>
    @endcomponent

    <div class="container">
        @include('partials.main-content')
    </div>
@endsection