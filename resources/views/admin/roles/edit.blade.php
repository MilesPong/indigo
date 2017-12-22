@extends('admin.layouts.app')

@section('title')
    Roles | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.roles.update', $role->id)])

        @include('admin.roles._form')

    @endcomponent

@endsection