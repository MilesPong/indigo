@extends('admin.layouts.app')

@section('title')
    @lang('menus.pages') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $pages,
        'columns' => [
            'id' => __('generic.attributes.id'),
            'title' => __('generic.attributes.title'),
            'human_status' => __('articles.attributes.is_draft'),
            'created_at' => __('generic.attributes.created_at')
        ],
        'hrefCreate' => route('admin.pages.create'),
        'hrefShow' => route('admin.pages.show', [':id', 'from' => 'admin']),
        'hrefEdit' => route('admin.pages.edit', ':id'),
        'hrefDestroy' => route('admin.pages.destroy', ':id'),
        'hrefForceDelete' => route('admin.pages.force-delete', ':id'),
        'hrefRestore' => route('admin.pages.restore', ':id'),
        'showTrash' => $showTrash ?? false
    ])
        @slot('fab')
            <ul>
                @if($showTrash)
                    <li><a class="btn-floating green" href="{{ route('admin.pages.index') }}"><i class="material-icons">playlist_add_check</i></a></li>
                @else
                    <li><a class="btn-floating yellow darken-1" href="{{ route('admin.pages.index', ['trash' => 'true']) }}"><i class="material-icons">delete_sweep</i></a></li>
                @endif
            </ul>
        @endslot
    @endcomponent

@endsection
