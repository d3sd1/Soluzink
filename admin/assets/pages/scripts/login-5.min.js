var Login = function() {
    var r = function() {
        $("#forget-password").click(function() {
            $(".login-form").hide(), $(".forget-form").show()
        }), $("#back-btn").click(function() {
            $(".login-form").show(), $(".forget-form").hide()
        })
    };
    return {
        init: function() {
            r(), $(".forget-form").hide()
        }
    }
}();
jQuery(document).ready(function() {
    Login.init()
});