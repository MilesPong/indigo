// https://getflywheel.com/layout/add-sticky-back-top-button-website/
jQuery(document).ready(function () {
    // Back to top
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
    });

    // Navigation bar's shadow control
    $(window).scroll(function () {
        let nav = $("#nav-bar");
        let scroll = $(window).scrollTop();
        if (scroll > 0) {
            nav.removeClass("z-depth-0");
            nav.addClass("z-depth-2");
        }
        else {
            nav.removeClass("z-depth-2");
            nav.addClass("z-depth-0");
        }
    });
});

// Navigation bar's dropdown
M.Dropdown.init(document.querySelector('.dropdown-trigger'));

// Side navigation bar
M.Sidenav.init(document.querySelector('.sidenav'));

// Collapsible in side navigation bar
M.Collapsible.init(document.querySelector('.collapsible'));

// Tool tipped
M.Tooltip.init(document.querySelector('.tooltipped'));

// Collapsible in archives page
M.Collapsible.init(document.querySelectorAll('.collapsible.expandable'), {
    accordion: false
});

// Footer locale dropdown
M.Dropdown.init(document.querySelector('.lang-dropdown-trigger'));