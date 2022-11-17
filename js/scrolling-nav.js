//jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("nav-scroll");
    } else {
        $(".navbar-fixed-top").removeClass("nav-scroll");
    }
});
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-brand").addClass("tv-scroll-logo");
    } else {
        $(".navbar-brand").removeClass("tv-scroll-logo");
    }
});
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-nav > li > a").addClass("menu-scroll-menu");
    } else {
        $(".navbar-nav > li > a").removeClass("menu-scroll-menu");
    }
});
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-nav").addClass("menu-active");
    } else {
        $(".navbar-nav").removeClass("menu-active");
    }
});