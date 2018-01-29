@inject('permission', 'App\Models\Permission')

<div class="row">
    <div class="input-field col s12 m6">
        <input id="name" type="text" class="validate" name="name" value="{{ $role->name ?? null }}">
        <label for="name">Name</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="display_name" type="text" class="validate" name="display_name"
               value="{{ $role->display_name ?? null }}">
        <label for="display_name">Display Name</label>
    </div>
    <div class="input-field col s12">
        <input id="description" type="text" class="validate" name="description"
               value="{{ $role->description ?? null }}">
        <label for="description">Description</label>
    </div>
    <div class="input-field col s12">
        @component('admin.components.select', [
            'name' => 'permission',
            'label' => 'Permissions',
            'isMultiple' => true,
            'selected' => isset($role) ? $role->perms->pluck('id')->toArray() : null
        ])
            @foreach($permission->all() as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
        @endcomponent
    </div>
</div>