@extends('admin.layouts.app')

@section('title')
    @lang('menus.categories') | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.categories.update', $category->id)])

        @include('admin.categories._form')

    @endcomponent

@endsection