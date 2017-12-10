{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label>Key</label>
    <input type="text" class="form-control" placeholder="Key" name="key" value="{{ old('key', $setting->key) }}">
</div>

<div class="form-group">
    <label>Value</label>
    <input type="text" class="form-control" placeholder="Value" name="value" value="{{ old('value', $setting->value) }}">
</div>

<div class="form-group">
    <label>Tag</label>
    <input type="text" class="form-control" placeholder="Tag" name="tag" value="{{ old('tag', $setting->tag) }}">
</div>

<div class="form-group">
    <button class="btn btn-primary pull-right" type="submit">
        {{ isset($setting->id) ? 'Save' : 'Submit' }}
    </button>
</div>
