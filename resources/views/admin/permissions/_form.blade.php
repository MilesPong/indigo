{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label>Permission Name</label>
    <input type="text" class="form-control" placeholder="" name="name" value="{{ old('name', $permission->name) }}"}>
</div>

<div class="form-group">
    <label>Display Name</label>
    <input type="text" class="form-control" placeholder="" name="display_name" value="{{ old('display_name', $permission->display_name) }}">
</div>

<div class="form-group">
    <label>Description</label>
    <textarea class="form-control" rows="3" name="description">{{ old('description', $permission->description) }}</textarea>
</div>

<div class="form-group">
    <button class="btn btn-primary pull-right" type="submit">
        {{ isset($permission->id) ? 'Save' : 'Submit' }}
    </button>
</div>