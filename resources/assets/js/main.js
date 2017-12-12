// https://getflywheel.com/layout/add-sticky-back-top-button-website/
jQuery(document).ready(function () {
    let topButton = jQuery('#up-to-top');

    topButton.hide();

    let offset = 250;
    let duration = 300;
    let scrollDuration = 1000;

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