{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control to-be-slug" placeholder="Category Name" name="name" value="{{ old('name', $category->name) }}">
</div>

<div class="form-group">
    <label>Description</label>
    <input type="text" class="form-control" placeholder="Description" name="description" value="{{ old('description', $category->description) }}">
</div>

<div class="form-group">
    <label>Slug</label>
    <input type="text" class="form-control" placeholder="Slug" name="slug" id="slug" value="{{ old('slug', $category->slug) }}">
</div>

<div class="form-group">
    <button class="btn btn-primary pull-right" type="submit">
        {{ isset($category->id) ? 'Save' : 'Submit' }}
    </button>
</div>
