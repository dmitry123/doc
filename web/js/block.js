
var UserForm = {
    construct: function() {
        var form = $("#user-login-form");
        form.form({
            url: form.attr("action"),
            locked: true
        });
        var btn = form.find("button:not([data-toggle])");
        var text = btn.text();
        btn.click(function() {
            $(this).html($("<div>").append(
                $("<span>", {
                    text: text
                })
            ).append(
                $("<img>", {
                    src: "img/ajax-loader.gif",
                    css: {
                        "margin-left": "10px",
                        "height": "20px"
                    }
                })
            ).html());
            form.data("doc").send(function() {
                setTimeout(function() {
                    btn.text(text);
                }, 250);
            });
        });
    }
};

$(document).ready(function() {
    UserForm.construct();
});