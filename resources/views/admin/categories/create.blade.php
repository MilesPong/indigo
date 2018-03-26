@extends('admin.layouts.app')

@section('title')
    @lang('menus.categories') | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.categories.store'),
        'redirectUrl' => route('admin.categories.index')
    ])

        @include('admin.categories._form')

    @endcomponent

@endsection