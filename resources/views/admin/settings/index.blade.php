@extends('admin.layouts.app')

@section('title')
    @lang('menus.settings') | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $settings,
        'columns' => [
            'id' => __('generic.attributes.id'),
            'key' => __('generic.attributes.key'),
            'value' => __('generic.attributes.value'),
            'tag' => __('generic.attributes.tag')
        ],
        'hrefCreate' => route('admin.settings.create'),
        'hrefEdit' => route('admin.settings.edit', ':id'),
        'hrefDestroy' => route('admin.settings.destroy', ':id'),
    ])
    @endcomponent

@endsection
