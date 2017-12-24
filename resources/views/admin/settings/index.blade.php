@extends('admin.layouts.app')

@section('title')
    Settings | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $settings,
        'columns' => [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'tag' => 'Tag'
        ],
        'hrefCreate' => route('admin.settings.create'),
        'hrefEdit' => route('admin.settings.edit', ':id'),
        'hrefDestroy' => route('admin.settings.destroy', ':id'),
    ])
    @endcomponent

@endsection
