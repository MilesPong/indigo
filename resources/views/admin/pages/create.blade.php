@extends('admin.layouts.app')

@section('title')
    Pages | @parent
@endsection

@section('content')

    @component('admin.components.form_create', [
        'formAction' => route('admin.pages.store'),
        'redirectUrl' => route('admin.pages.index')
    ])

        @include('admin.pages._form')

    @endcomponent

@endsection