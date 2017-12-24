@extends('admin.layouts.app')

@section('title')
    tags | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $tags,
        'columns' => [
            'name' => 'Name',
            'description' => 'Description',
            'slug' => 'Slug'
        ],
        'hrefCreate' => route('admin.tags.create'),
        'hrefShow' => route('admin.tags.show', ':id'),
        'hrefEdit' => route('admin.tags.edit', ':id'),
        'hrefDestroy' => route('admin.tags.destroy', ':id'),
    ])
    @endcomponent

@endsection
