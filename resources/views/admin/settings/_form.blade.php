<div class="row">
    <div class="input-field col s12">
        <input id="key" type="text" class="validate" name="key" value="{{ $setting->key ?? null }}">
        <label for="key">@lang('generic.attributes.key')</label>
    </div>
    <div class="input-field col s12">
        <input id="value" type="text" class="validate" name="value" value="{{ $setting->value ?? null }}">
        <label for="value">@lang('generic.attributes.value')</label>
    </div>
    <div class="input-field col s12">
        <input id="tag" type="text" class="validate" name="tag" value="{{ $setting->tag ?? null }}">
        <label for="tag">@lang('generic.attributes.tag')</label>
    </div>
</div>