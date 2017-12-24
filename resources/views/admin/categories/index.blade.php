@extends('admin.layouts.app')

@section('title')
    Categories | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $categories,
        'columns' => [
            'name' => 'ID',
            'description' => 'Description',
            'slug' => 'Slug'
        ],
        'hrefCreate' => route('admin.categories.create'),
        'hrefShow' => route('admin.categories.show', ':id'),
        'hrefEdit' => route('admin.categories.edit', ':id'),
        'hrefDestroy' => route('admin.categories.destroy', ':id'),
    ])
    @endcomponent

@endsection
