@extends('admin.layouts.app')

@section('title')
    Users | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.users.update', $user->id)])

        @include('admin.users._form')

    @endcomponent

@endsection