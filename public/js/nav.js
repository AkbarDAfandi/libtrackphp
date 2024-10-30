$(document).ready(function() {
    $('.hamburger-menu').click(function() {
        $('.sidebar').toggleClass('active');
        $('.menu-items').toggleClass('show');
    });

    // Close sidebar when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('.sidebar, .hamburger-menu').length) {
            $('.sidebar').removeClass('active');
            $('.menu-items').removeClass('show');
        }
    });

    $("nav ul li a").on("click", function() {
        $("nav ul li a").removeClass("active");
        $(this).addClass("active");
    });

    var currentPage = window.location.search.split('=')[1] || 'home';
    $('nav ul li a[href$="' + currentPage + '"]').addClass('active');
});
