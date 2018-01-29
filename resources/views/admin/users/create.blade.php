@extends('admin.layouts.app')

@section('title')
    Users | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.users.store'),
        'redirectUrl' => route('admin.users.index')
    ])

        @include('admin.users._form')

    @endcomponent

@endsection