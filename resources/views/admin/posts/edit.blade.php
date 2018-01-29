@extends('admin.layouts.app')

@section('title')
    Posts | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.posts.update', $post->id)])

        @include('admin.posts._form')

    @endcomponent

@endsection