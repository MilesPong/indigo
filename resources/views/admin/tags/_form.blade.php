{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" placeholder="Tag Name" name="name" value="{{ old('name', $tag->name) }}">
</div>

<div class="form-group">
    <label>Description</label>
    <input type="text" class="form-control" placeholder="Description" name="description" value="{{ old('description', $tag->description) }}">
</div>

<div class="form-group">
    <label>Slug</label>
    <input type="text" class="form-control" placeholder="Slug" name="slug" value="{{ old('slug', $tag->slug) }}">
</div>

<div class="form-group">
    <button class="btn btn-primary pull-right" type="submit">
        {{ isset($tag->id) ? 'Save' : 'Submit' }}
    </button>
</div>
