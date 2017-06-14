@extends('layouts.app')

@section('content')
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
@endsection