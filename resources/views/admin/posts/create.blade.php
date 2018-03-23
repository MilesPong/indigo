@extends('admin.layouts.app')

@section('title')
    @lang('menus.posts') | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.posts.store'),
        'redirectUrl' => route('admin.posts.index')
    ])

        @include('admin.posts._form')

    @endcomponent

@endsection