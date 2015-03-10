
var UserForm = {
    construct: function() {
        var form = $("#user-login-form");
        form.form({
            url: form.attr("action")
        });
        form.find("button[type='submit']").click(function() {
            form.data("doc").send();
        });
    }
};

$(document).ready(function() {
    UserForm.construct();
});