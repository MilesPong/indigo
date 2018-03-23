@extends('admin.layouts.app')

@section('title')
    @lang('menus.pages') | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.pages.store'),
        'redirectUrl' => route('admin.pages.index')
    ])

        @include('admin.pages._form')

    @endcomponent

@endsection