@extends('admin.layouts.app')

@section('title')
    settings | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.settings.update', $setting->id)])

        @include('admin.settings._form')

    @endcomponent

@endsection