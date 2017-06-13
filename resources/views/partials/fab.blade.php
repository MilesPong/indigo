<div class="fixed-action-btn" id="up-to-top">
    <a href="#!" class="btn-floating btn-large waves-effect waves-light waves-circle red">
        <i class="material-icons large">expand_less</i>
    </a>
    {{--<ul>--}}
    {{--<li><a href="#!" class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>--}}
    {{--<li><a href="#!" class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>--}}
    {{--<li><a href="#!" class="btn-floating green"><i class="material-icons">publish</i></a></li>--}}
    {{--<li><a href="#!" class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>--}}
    {{--</ul>--}}
</div>

@push('js')
<script>
    {{-- https://getflywheel.com/layout/add-sticky-back-top-button-website/ --}}
    jQuery(document).ready(function () {
        var topButton = jQuery('#up-to-top');

        topButton.hide();

        var offset = 250;
        var duration = 300;

        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > offset) {
                topButton.fadeIn(duration);
            } else {
                topButton.fadeOut(duration);
            }
        });

        topButton.click(function (event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        })
    });
</script>
@endpush