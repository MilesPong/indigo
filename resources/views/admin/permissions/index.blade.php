@extends('admin.layouts.app')

@section('title')
    @lang('menus.permissions') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $permissions,
        'columns' => [
            'id' => __('generic.attributes.id'),
            'name' => __('generic.attributes.name'),
            'display_name' => __('generic.attributes.display_name'),
            'description' => __('generic.attributes.description')
        ],
        'hrefCreate' => route('admin.permissions.create'),
        'hrefShow' => route('admin.permissions.show', ':id'),
        'hrefEdit' => route('admin.permissions.edit', ':id'),
        'hrefDestroy' => route('admin.permissions.destroy', ':id'),
    ])
    @endcomponent

@endsection
