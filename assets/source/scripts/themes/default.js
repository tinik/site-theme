
jQuery(document).ready(function() {
    jQuery(document).foundation();

    var doc = document.documentElement;
    doc.setAttribute('data-useragent', navigator.userAgent);

    var icon = document.createElement('i');
    icon.setAttribute('class', 'fa fa-chevron-circle-up');

    var up = document.createElement('a');
    up.setAttribute('id', 'up');
    up.appendChild(icon);

    document.body.appendChild(up);

    // show the buttons
    var top = jQuery(up);
    top.click(function(e) {
        // clicking the "up" button will make the page scroll to the top of the page
        jQuery('html, body').animate({scrollTop: '5px'}, 'slow');
    });

    jQuery(window).scroll(function(event) {
        if(window.scrollY > 400) {
            top.stop().animate({'opacity':'.7'});
        } else if(window.scrollY < 380) {
            top.stop().animate({'opacity':0});
        }
    });
});
