@extends('admin.layouts.app')

@section('title')
    settings | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.settings.store'),
        'redirectUrl' => route('admin.settings.index')
    ])

        @include('admin.settings._form')

    @endcomponent

@endsection