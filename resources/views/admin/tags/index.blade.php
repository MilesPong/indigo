@extends('admin.layouts.app')

@section('title')
    @lang('menus.tags') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $tags,
        'columns' => [
            'name' => __('generic.attributes.name'),
            'description' => __('generic.attributes.description'),
            'slug' => __('generic.attributes.slug')
        ],
        'hrefCreate' => route('admin.tags.create'),
        'hrefShow' => route('admin.tags.show', ':id'),
        'hrefEdit' => route('admin.tags.edit', ':id'),
        'hrefDestroy' => route('admin.tags.destroy', ':id'),
    ])
    @endcomponent

@endsection
