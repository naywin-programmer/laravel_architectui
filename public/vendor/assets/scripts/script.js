$(function() {
    let path = window.location.href;
    $('a.sidebar-item').removeClass('mm-active');
    $("a.sidebar-item").each(function () {
        let href = $(this).attr('href');
        if (path === href) {
            $(this).addClass('mm-active');
        }
    });
});