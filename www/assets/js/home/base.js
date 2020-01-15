"undefined",
    function() {
        "use strict";
        $(function() {
            $(".logo a").not(".logo-landing").on({
                mouseenter: function(a) {
                    $(this).stop().animate({
                        opacity: .7
                    })
                },
                mouseleave: function(a) {
                    $(this).stop().animate({
                        opacity: 1
                    })
                }
            });
        })
    }();
$(document).ready(function() {
    $("#langSelectorCallbacked").each(function( index ) {
        $(this).attr("href", $(this).attr("href").replace('*callBackUrl*',btoa(window.location.href)));
    });
});