@extends('admin.layouts.app')

@section('title')
    @lang('menus.users') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $users,
        'columns' => [
            'name' => __('generic.attributes.name'),
            'email' => __('generic.attributes.email'),
            'created_at' => __('generic.attributes.created_at'),
            'updated_at' => __('generic.attributes.updated_at')
        ],
        'hrefCreate' => route('admin.users.create'),
        'hrefShow' => route('admin.users.show', ':id'),
        'hrefEdit' => route('admin.users.edit', ':id'),
        'hrefDestroy' => route('admin.users.destroy', ':id'),
    ])
    @endcomponent

@endsection
