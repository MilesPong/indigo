@inject('role', 'App\Models\Role')

<div class="row">
    <div class="input-field col s12 m6">
        <input id="name" type="text" class="validate" name="name" value="{{ $user->name ?? null }}">
        <label for="name">Name</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="email" type="text" class="validate" name="email" value="{{ $user->email ?? null }}">
        <label for="email">Email</label>
    </div>

    <div class="input-field col s12 m6">
        <input id="password" type="password" class="validate" name="password">
        <label for="password">Password</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="password_confirmation" type="password" class="validate" name="password_confirmation">
        <label for="password_confirmation">Confirm Password</label>
    </div>

    <div class="input-field col s12">
        @component('admin.components.select', [
            'name' => 'role',
            'label' => 'Roles',
            'isMultiple' => true,
            'selected' => isset($user) ? $user->roles->pluck('id')->toArray() : null
        ])
            @foreach($role->all() as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        @endcomponent
    </div>
</div>