@inject('role', 'App\Models\Role')

<div class="row">
    <div class="input-field col s12 m6">
        <input id="name" type="text" class="validate" name="name" value="{{ $user->name ?? null }}">
        <label for="name">@lang('generic.attributes.name')</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="email" type="text" class="validate" name="email" value="{{ $user->email ?? null }}">
        <label for="email">@lang('generic.attributes.email')</label>
    </div>

    <div class="input-field col s12 m6">
        <input id="password" type="password" class="validate" name="password">
        <label for="password">@lang('generic.attributes.password')</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="password_confirmation" type="password" class="validate" name="password_confirmation">
        <label for="password_confirmation">@lang('generic.attributes.confirm_password')</label>
    </div>

    <div class="input-field col s12">
        @component('admin.components.select', [
            'name' => 'role',
            'label' => trans_choice('generic.model.role', PLURAL),
            'isMultiple' => true,
            'selected' => isset($user) ? $user->roles->pluck('id')->toArray() : null
        ])
            @foreach($role->all() as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        @endcomponent
    </div>
</div>