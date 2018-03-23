@extends('admin.layouts.app')

@section('title')
    @lang('menus.tags') | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.tags.store'),
        'redirectUrl' => route('admin.tags.index')
    ])

        @include('admin.tags._form')

    @endcomponent

@endsection