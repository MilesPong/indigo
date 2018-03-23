<div class="row">
    <div class="input-field col s12 m6">
        <input id="name" type="text" class="validate" name="name" value="{{ $tag->name ?? null }}">
        <label for="name">@lang('generic.attributes.name')</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="slug" type="text" class="validate" name="slug" value="{{ $tag->slug ?? null }}">
        <label for="slug">@lang('generic.attributes.slug')</label>
    </div>
    <div class="input-field col s12">
        <input id="description" type="text" class="validate" name="description" value="{{ $tag->description ?? null }}">
        <label for="description">@lang('generic.attributes.description')</label>
    </div>
</div>