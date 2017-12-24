<div class="row">
    <div class="input-field col s12 m6">
        <input id="name" type="text" class="validate" name="name" value="{{ $category->name ?? null }}">
        <label for="name">Name</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="slug" type="text" class="validate" name="slug" value="{{ $category->slug ?? null }}">
        <label for="slug">Slug</label>
    </div>
    <div class="input-field col s12">
        <input id="description" type="text" class="validate" name="description" value="{{ $category->description ?? null }}">
        <label for="description">Description</label>
    </div>
</div>