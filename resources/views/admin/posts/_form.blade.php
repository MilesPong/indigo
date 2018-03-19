<div class="row">
    <div class="input-field col s12 m6">
        <input id="title" type="text" class="validate" name="title" value="{{ $post->title ?? null }}">
        <label for="title">Title</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="slug" type="text" class="validate" name="slug" value="{{ $post->slug ?? null }}" @if(isset($post->id))readonly="readonly"@endif>
        <label id="slug-label" for="slug">Slug</label>
    </div>

    <div class="input-field col s12 m6">
        @component('admin.components.select', [
            'name' => 'category_id',
            'label' => 'Category',
            'selected' => isset($post) ? $post->category_id : null
        ])
            @foreach(App\Models\Category::all() as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        @endcomponent
    </div>

    {{-- TODO dynamic add tags --}}
    <div class="input-field col s12 m6">
        @component('admin.components.select', [
            'name' => 'tag',
            'label' => 'Tags',
            'isMultiple' => true,
            'selected' => isset($post) ? $post->tags->pluck('name')->toArray() : null
        ])
            @foreach(App\Models\Tag::all() as $tag)
                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
            @endforeach
        @endcomponent
    </div>

    <div class="input-field col s12">
        <textarea id="description" class="materialize-textarea" type="text" name="description">{{ $post->description ?? null }}</textarea>
        <label for="description">Description</label>
    </div>

    {{-- TODO show image --}}
    <div class="input-field col s8">
        <input id="feature_img" placeholder="e.g. https://example.org/one.jpg" type="text" class="validate" name="feature_img" value="{{ $post->feature_img ?? null }}">
        <label for="feature_img">Feature Image</label>
    </div>

    <div class="input-field file-field col s4">
        <div class="btn">
            <span>Upload</span>
            <input id="file-upload" type="file" accept="image/*">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>

    <div class="input-field col s12 body-field">
        <textarea id="body" class="materialize-textarea" name="body">{{ isset($post->id) ? $post->rawContent : null }}</textarea>
        <label id="body-label" for="body">Content</label>
    </div>

    <div class="input-field col s6">
        <input id="published_date" type="hidden" class="datepicker">
        {{--<label for="published_date">Published Date</label>--}}
    </div>

    <div class="input-field col s6">
        <input id="published_time" type="hidden" class="timepicker">
        {{--<label for="published_time">Published Time</label>--}}
    </div>

    <div class="input-field col s12">
        <input type="text" name="published_at" id="published_at" value="{{ isset($post->id) ? $post->published_at->toDatetimeString() : null }}" readonly>
        <label id="published_at-label" for="published_at">Published At</label>
    </div>

    <div class="input-field col s12">
        <div class="switch">
            <label>
                Publish
                <input type="checkbox" name="is_draft" id="is_draft" @if($post->is_draft ?? false)checked="checked"@endif>
                <span class="lever"></span>
                Draft
            </label>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('css/simplemde.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/editor.css', 'backend') }}">
@endpush

@push('js')
    <script src="{{ asset('js/simplemde.min.js') }}"></script>
    <script>
        let $imageUploadURL = '{{ route('admin.helpers.upload.image') }}';
        let $slugTranslationURL = '{{ route('admin.helpers.slug.translate') }}';
    </script>
    <script src="{{ mix('js/editor.js', 'backend') }}"></script>
@endpush