@extends('layouts.base')

@section('title')
    {{ $category->name }} | @parent
@endsection

@section('keywords'){{ $category->name }}@endsection
@section('description'){{ $category->description }}@endsection

@section('content')
    @component('components.header')
        <div class="center white-text">
            <div class="row">
                <h2>Category: {{ $category->name }}</h2>
                <p class="flow-text">{{ $category->description }}</p>
            </div>
        </div>
    @endcomponent

    <div class="container">
        @include('partials.main-content')
    </div>
@endsection