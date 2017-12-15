@extends('admin.layouts.app')

@section('title')
    Permissions | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.permissions.update', $permission->id)])

        @include('admin.permissions._form')

    @endcomponent

@endsection