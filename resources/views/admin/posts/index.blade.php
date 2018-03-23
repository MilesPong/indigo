@extends('admin.layouts.app')

@section('title')
    @lang('menus.posts') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $posts,
        'columns' => [
            'id' => __('generic.attributes.id'),
            'title' => __('generic.attributes.title'),
            'author.name' => __('articles.attributes.author'),
            'category.name' => trans_choice('generic.model.category', SINGULAR),
            'created_at' => __('generic.attributes.created_at')
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
