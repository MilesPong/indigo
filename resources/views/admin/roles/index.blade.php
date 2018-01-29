@extends('admin.layouts.app')

@section('title')
    Roles | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $roles,
        'columns' => [
            'id' => 'ID',
            'name' => 'Role Name',
            'display_name' => 'Display Name',
            'description' => 'Description'
        ],
        'hrefCreate' => route('admin.roles.create'),
        'hrefShow' => route('admin.roles.show', ':id'),
        'hrefEdit' => route('admin.roles.edit', ':id'),
        'hrefDestroy' => route('admin.roles.destroy', ':id'),
    ])
    @endcomponent

@endsection
