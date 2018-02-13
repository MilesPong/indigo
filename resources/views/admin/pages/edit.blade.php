@extends('admin.layouts.app')

@section('title')
    Pages | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.pages.update', $page->id)])

        @include('admin.pages._form')

    @endcomponent

@endsection