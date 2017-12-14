@extends('admin.layouts.app')

@section('title')
    Permission | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $permissions,
        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'display_name' => 'Display Name',
            'description' => 'Description'
        ],
        'hrefShow' => route('admin.permissions.show', ':id'),
        'hrefEdit' => route('admin.permissions.edit', ':id'),
        'hrefDestroy' => route('admin.permissions.destroy', ':id'),
    ])
    @endcomponent

    @component('admin.components.fab', ['link' => route('admin.permissions.create')])

    @endcomponent

@endsection
