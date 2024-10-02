$(document).ready(function() {
    $("nav ul li a").on("click", function() {
        $("nav ul li a").removeClass("active");
        $(this).addClass("active");
    });

    // Set active class based on current page
    var currentPage = window.location.search.split('=')[1] || 'home';
    $('nav ul li a[href$="' + currentPage + '"]').addClass('active');
});
