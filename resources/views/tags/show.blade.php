@extends('layouts.app')

@section('title')
    {{ $tag->name }} | @parent
@endsection

@section('keywords'){{ $tag->name }}@endsection
@section('description'){{ $tag->description }}@endsection

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h2>{{ $tag->name }}</h2>
                <p class="flow-text">{{ $tag->description }}</p>
            </div>
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