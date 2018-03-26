<div class="row">
    <div class="input-field col s12 m6">
        <input id="title" type="text" class="validate" name="title" value="{{ $page->title ?? null }}">
        <label for="title">@lang('generic.attributes.title')</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="slug" type="text" class="validate" name="slug" value="{{ $page->slug ?? null }}" @if(isset($page->id))readonly="readonly"@endif>
        <label id="slug-label" for="slug">@lang('generic.attributes.slug')</label>
    </div>

    <div class="input-field col s12">
        <textarea id="description" class="materialize-textarea" name="description">{{ $page->description ?? null }}</textarea>
        <label for="description">@lang('generic.attributes.description')</label>
    </div>

    <div class="input-field col s12 body-field">
        <textarea id="body" class="materialize-textarea" type="text" name="body">{{ isset($page->id) ? $page->rawContent : null }}</textarea>
        <label id="body-label" for="body">@lang('articles.attributes.content')</label>
    </div>

    <div class="input-field col s12">
        <div class="switch">
            <label>
                @lang('generic.publish')
                <input type="checkbox" name="is_draft" id="is_draft" @if($page->is_draft ?? false)checked="checked"@endif>
                <span class="lever"></span>
                @lang('generic.draft')
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