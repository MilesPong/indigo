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
        $.post($slugTranslationURL, {text})
            .done(data => {
                $('#slug').val(data.slug);
                $('#slug-label').addClass('active');
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                // Log the error to the console
                console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                );
            })
    });

    /*
    * TODO
    * 1. use axios
    * 2. uploading feedback
    * 3. result feedback
    * */
    $('#file-upload').change(e => {
        let fd = new FormData();
        fd.append('image', e.target.files[0]);

        $.ajax({
            url: $imageUploadURL,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false
        }).done(data => {
            console.log(data);
            $('#feature_img').val(data.path);
        }).fail((jqXHR, textStatus, errorThrown) => {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
            swal(
                'Oops...',
                'Something went wrong!',
                'error'
            )
        })
    });

    $('#body-label').addClass('active');

    $('#published_at').click(() => {
        dateInstance.open()
    });

    $('#published_time').change((e) => {
        $('#published_at').val($('#published_date').val() + ' ' + e.target.value);
        $('#published_at-label').addClass('active');
    });
});

let simplemde = new SimpleMDE({
    element: document.getElementById("body"),
    spellChecker: false // Multiple languages haven't been supported yet
});

// TODO temporarily fixed empty form body string when first submit
simplemde.codemirror.on("change", function () {
    $('#body').val(simplemde.value());
});

let timeInstance = M.Timepicker.init(document.querySelector('.timepicker'));

let dateInstance = M.Datepicker.init(document.querySelector('.datepicker'), {
    format: 'yyyy-mm-dd',
    onClose: () => {
        if ($('#published_date').val()) {
            // TODO will-change memory exhausted?
            timeInstance.open();
        }
    }
});