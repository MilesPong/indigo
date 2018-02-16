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
        'hrefShow' => route('admin.posts.show', [':id', 'from' => 'admin']),
        'hrefEdit' => route('admin.posts.edit', ':id'),
        'hrefDestroy' => route('admin.posts.destroy', ':id'),
        'hrefForceDelete' => route('admin.posts.force-delete', ':id'),
        'hrefRestore' => route('admin.posts.restore', ':id'),
        'showTrash' => $showTrash ?? false
    ])
        @slot('fab')
            <ul>
                @if(!empty($showTrash))
                    <li><a class="btn-floating green" href="{{ route('admin.posts.index') }}"><i class="material-icons">playlist_add_check</i></a></li>
                @else
                    <li><a class="btn-floating yellow darken-1" href="{{ route('admin.posts.index', ['trash' => 'true']) }}"><i class="material-icons">delete_sweep</i></a></li>
                @endif
            </ul>
        @endslot
    @endcomponent

@endsection
