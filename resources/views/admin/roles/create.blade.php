@extends('admin.layouts.app')

@section('title')
    @lang('menus.roles') | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.roles.store'),
        'redirectUrl' => route('admin.roles.index')
    ])

        @include('admin.roles._form')

    @endcomponent

@endsection