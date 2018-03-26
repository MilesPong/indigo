@extends('admin.layouts.app')

@section('title')
    @lang('menus.categories') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $categories,
        'columns' => [
            'name' => __('generic.attributes.name'),
            'description' => __('generic.attributes.description'),
            'slug' => __('generic.attributes.slug')
        ],
        'hrefCreate' => route('admin.categories.create'),
        'hrefShow' => route('admin.categories.show', ':id'),
        'hrefEdit' => route('admin.categories.edit', ':id'),
        'hrefDestroy' => route('admin.categories.destroy', ':id'),
    ])
    @endcomponent

@endsection
