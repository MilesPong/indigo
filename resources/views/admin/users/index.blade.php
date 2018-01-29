@extends('admin.layouts.app')

@section('title')
    Users | @parent
@endsection

@section('content')

    @component('admin.components.table', [
        'paginator' => $users,
        'columns' => [
            'name' => 'Name',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ],
        'hrefCreate' => route('admin.users.create'),
        'hrefShow' => route('admin.users.show', ':id'),
        'hrefEdit' => route('admin.users.edit', ':id'),
        'hrefDestroy' => route('admin.users.destroy', ':id'),
    ])
    @endcomponent

@endsection
