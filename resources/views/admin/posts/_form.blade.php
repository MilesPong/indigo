{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label>Title</label>
    <input type="text" class="form-control" placeholder="Title" name="title" value="{{ old('title', $post->title) }}">
</div>

<div class="form-group">
    <label>Description</label>
    <input type="text" class="form-control" placeholder="Description" name="description" value="{{ old('description', $post->description) }}">
</div>

<div class="form-group">
    <label>Slug</label>
    <input type="text" class="form-control" placeholder="Slug" name="slug" value="{{ old('slug', $post->slug) }}">
</div>

<div class="form-group">
    <label>Category</label>
    <select class="form-control select2 category-selected" name="category_id" style="width: 100%;">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Tags</label>
    <select name="tag[]" class="form-control select2 tags-selected" multiple="multiple" data-placeholder="Select Tag(s)" style="width: 100%;">
        @foreach($tags as $tag)
            <option value="{{ $tag->name }}">{{ $tag->name }}</option>
        @endforeach
    </select>
</div>

<textarea id="mdeditor" name="content">{{ old('content') ?: $post->content }}</textarea>

<div class="form-group">
    <button class="btn btn-primary pull-right" type="submit">
        {{ isset($post->id) ? 'Save' : 'Submit' }}
    </button>
</div>

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/simplemde.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/simplemde.min.js') }}"></script>
<script>
    $(function () {
        var simplemde = new SimpleMDE({element: $("#mdeditor")[0]});
    });

    $(".category-selected").select2().val([{{ old('category_id', isset($post->category_id) ? $post->category_id : null)}}]).trigger('change');

    $(".tags-selected").select2({tags:true}).val([{!! $post->present()->selectedTags !!}]).trigger('change');
</script>
@endpush
