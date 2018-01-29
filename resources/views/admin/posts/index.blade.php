@extends('admin.layouts.app')

@section('title')
    Posts | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $posts,
        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'author.name' => 'Author',
            'category.name' => 'Category',
            'created_at' => 'Created At'
        ],
        'hrefCreate' => route('admin.posts.create'),
        'hrefShow' => route('admin.posts.show', ':id'),
        'hrefEdit' => route('admin.posts.edit', ':id'),
        'hrefDestroy' => route('admin.posts.destroy', ':id'),
    ])
    @endcomponent

@endsection
