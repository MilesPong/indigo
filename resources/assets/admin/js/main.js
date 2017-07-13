jQuery(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".to-be-slug").blur(function () {

        // TODO Leave if update
        if ($("input[name='_method']").val() == 'PATCH' ) {
            return;
        }

        var value = $(this).val();
        if (value) {
            $.post("/dashboard/auto-slug", {text: value})
                .done(function (data) {
                    $("#slug").val(data);
                })
                .fail(function (jqXHR, textStatus) {
                    alert('Auto slug error.');
                    // console.log(jqXHR);
                    // console.log(textStatus);
                })
        }
    });
});