@extends('admin.layouts.app')

@section('title')
    Permissions | @parent
@endsection

@section('content')

    @component('admin.components.form', ['formAction' => route('admin.permissions.store')])
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="name" type="text" class="validate" name="name">
                <label for="name">Name</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="display_name" type="text" class="validate" name="display_name">
                <label for="display_name">Display Name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea id="description" class="materialize-textarea" name="description"></textarea>
                <label for="description">Description</label>
            </div>
        </div>
    @endcomponent

@endsection