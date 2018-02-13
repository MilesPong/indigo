<div class="row">
    <div class="input-field col s12 m6">
        <input id="title" type="text" class="validate" name="title" value="{{ $page->title ?? null }}">
        <label for="title">Title</label>
    </div>
    <div class="input-field col s12 m6">
        <input id="slug" type="text" class="validate" name="slug" value="{{ $page->slug ?? null }}" @if(isset($page->id))readonly="readonly"@endif>
        <label id="slug-label" for="slug">Slug</label>
    </div>

    <div class="input-field col s12">
        <textarea id="description" class="materialize-textarea" type="text" name="description">{{ $page->description ?? null }}</textarea>
        <label for="description">Description</label>
    </div>

    <div class="input-field col s12 body-field">
        <textarea id="body" class="materialize-textarea" type="text" name="body">{{ isset($page->id) ? $page->rawContent : null }}</textarea>
        <label id="body-label" for="body">Content</label>
    </div>

    <div class="input-field col s12">
        <div class="switch">
            <label>
                Publish
                <input type="checkbox" name="is_draft" id="is_draft" @if($page->is_draft ?? false)checked="checked"@endif>
                <span class="lever"></span>
                Draft
            </label>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('css/simplemde.min.css') }}">
    <style>
        .editor-toolbar {
            margin-top: 15px;
        }
        .body-field .CodeMirror-fullscreen {
            top: 110px;
        }
        .body-field .fullscreen {
            margin-top: 64px;
        }
        @media only screen and (min-width: 993px) {
            .body-field .CodeMirror-fullscreen, .body-field .fullscreen {
                margin-left: 300px;
            }
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('js/simplemde.min.js') }}"></script>
    <script>
        $(function () {
            $('#description').trigger('autoresize');

            /*
            * TODO
            * 1. use axios
            * 2. result feedback
            * */
            $('#title').blur(e => {
                let text = e.target.value;
                if (!text || $('#slug').val()) {
                    return;
                }
                $.post('{{ route("admin.helpers.slug.translate") }}', {text})
                    .done(data => {
                        $('#slug').val(data.slug);
                        $('#slug-label').addClass('active');
                    })
                    .fail((jqXHR, textStatus, errorThrown) => {
                        // Log the error to the console
                        console.error(
                            "The following error occurred: "+
                            textStatus, errorThrown
                        );
                    })
            });

            $('#body-label').addClass('active');
        });

        let simplemde = new SimpleMDE({ element: document.getElementById("body") });

        // TODO temporarily fixed empty form body string when first submit
        simplemde.codemirror.on("change", function(){
            $('#body').val(simplemde.value());
        });
    </script>
@endpush