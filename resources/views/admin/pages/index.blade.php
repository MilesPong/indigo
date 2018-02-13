@extends('admin.layouts.app')

@section('title')
    Pages | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $pages,
        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'author.name' => 'Author',
            'human_status' => 'Status',
            'created_at' => 'Created At'
        ],
        'hrefCreate' => route('admin.pages.create'),
        'hrefShow' => route('admin.pages.show', ':id'),
        'hrefEdit' => route('admin.pages.edit', ':id'),
        'hrefDestroy' => route('admin.pages.destroy', ':id'),
    ])
    @endcomponent

@endsection
