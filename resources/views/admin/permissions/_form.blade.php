<div class="row">
    <div class="input-field col s12 m6">
        <input id="name" type="text" class="validate" name="name" value="{{ $permission->name ?? null }}">
        <label for="name">@lang('generic.attributes.name')</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="display_name" type="text" class="validate" name="display_name" value="{{ $permission->display_name ?? null }}">
        <label for="display_name">@lang('generic.attributes.display_name')</label>
    </div>
</div>
<div class="row">
    <div class="input-field col s12">
        <input id="description" type="text" class="validate" name="description" value="{{ $permission->description ?? null }}">
        <label for="description">@lang('generic.attributes.description')</label>
    </div>
</div>