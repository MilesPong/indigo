// https://getflywheel.com/layout/add-sticky-back-top-button-website/
jQuery(document).ready(function () {
    var topButton = jQuery('#up-to-top');

    topButton.hide();

    var offset = 250;
    var duration = 300;
    var scrollDuration = 1000;

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > offset) {
            topButton.fadeIn(duration);
        } else {
            topButton.fadeOut(duration);
        }
    });

    topButton.click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, scrollDuration);
        return false;
    })
});