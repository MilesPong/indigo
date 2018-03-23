@extends('admin.layouts.app')

@section('title')
    @lang('menus.roles') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $roles,
        'columns' => [
            'id' => __('generic.attributes.id'),
            'name' => __('generic.attributes.name'),
            'display_name' => __('generic.attributes.display_name'),
            'description' => __('generic.attributes.description')
        ],
        'hrefCreate' => route('admin.roles.create'),
        'hrefShow' => route('admin.roles.show', ':id'),
        'hrefEdit' => route('admin.roles.edit', ':id'),
        'hrefDestroy' => route('admin.roles.destroy', ':id'),
    ])
    @endcomponent

@endsection
