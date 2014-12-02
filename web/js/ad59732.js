$( document ).ready(function() {
    $('.table tbody tr').mouseenter(function() {
        if(!$(this).hasClass('notRead'))
            $(this).css("background-color", "#cc392f");
    });
    $('.table tbody tr').mouseleave(function() {
        if(!$(this).hasClass('notRead'))
            $(this).css("background-color", "#fff");
    });
    $('.table tbody tr').hover(function() {
        $(this).css("cursor", "pointer");
    });
});
