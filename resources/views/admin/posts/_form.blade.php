{{ csrf_field() }}

<!-- text input -->
<div class="form-group">
    <label for="title" class="col-sm-1 control-label">Title</label>

    <div class="col-sm-11">
        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ old('title', $post->title) }}">
    </div>
</div>

<div class="form-group">
    <label for="description" class="col-sm-1 control-label">Description</label>

    <div class="col-sm-11">
        <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="{{ old('description', $post->description) }}">
    </div>
</div>

<div class="form-group">
    <label for="slug" class="col-sm-1 control-label">Slug</label>

    <div class="col-sm-11">
        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="{{ old('slug', $post->slug) }}">
    </div>
</div>

<div class="form-group">
    <label for="category_id" class="col-sm-1 control-label">Category</label>
    <div class="col-sm-11">
        <select class="form-control select2 category-selected" name="category_id" style="width: 100%;">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-sm-1 control-label">Tags</label>
    <div class="col-sm-11">
        <select name="tag[]" class="form-control select2 tags-selected" multiple="multiple" data-placeholder="Select Tag(s)" style="width: 100%;">
            @foreach($tags as $tag)
                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="content" class="col-sm-1 control-label">Content</label>

    <div class="col-sm-11">
        <textarea id="mdeditor" name="content">{{ old('content') ?: $post->content }}</textarea>
    </div>
</div>

<div class="form-group">
    <label for="published_at" class="col-sm-1 control-label">Published At</label>

    <div class='col-sm-11'>
        <input type='text' class="form-control" name="published_at" id="published_at" placeholder="Published At" value="{{ $post->present()->publishedTime }}"/>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-1 control-label">Draft</div>

    <div class="col-sm-11">
        <input type="checkbox" name="is_draft" id="is_draft" @if(old('is_draft', $post->is_draft))checked="checked"@endif>
        <label>Is Draft</label>
    </div>
</div>

@push('box-footer')
<div class="box-footer">
    <button class="btn btn-primary btn-lg btn-flag pull-right" type="submit">
        {{ isset($post->id) ? 'Save' : 'Submit' }}
    </button>
</div>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/simplemde.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endpush

@push('js')
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/simplemde.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(function () {
        var simplemde = new SimpleMDE({element: $("#mdeditor")[0]});

        $(".category-selected").select2().val([{{ old('category_id', isset($post->category_id) ? $post->category_id : null)}}]).trigger('change');

        $(".tags-selected").select2({tags:true}).val([{!! $post->present()->selectedTags !!}]).trigger('change');

        $('#published_at').datetimepicker();

        $('#is_draft').each(function(){
            var self = $(this),
                label = self.next(),
                label_text = label.text();

            label.remove();
            self.iCheck({
                checkboxClass: 'icheckbox_line-blue',
                radioClass: 'iradio_line-blue',
                insert: '<div class="icheck_line-icon"></div>' + label_text
            });
        });
    });
</script>
@endpush
