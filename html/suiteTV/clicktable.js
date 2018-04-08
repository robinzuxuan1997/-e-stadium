$(document).ready(function() {

    $('#main tr').click(function() {
        window.location=order.php;
        var href = $(this).find("a").attr("href");
        if(href == '1') {
            window.location = order.php;
        }
    });

});