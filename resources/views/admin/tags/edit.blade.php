@extends('admin.layouts.app')

@section('title')
    tags | @parent
@endsection

@section('content')

    @component('admin.components.form_update', ['formAction' => route('admin.tags.update', $tag->id)])

        @include('admin.tags._form')

    @endcomponent

@endsection