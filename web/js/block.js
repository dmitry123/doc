
var UserForm = {
    construct: function() {
        var form = $("#user-login-form");
        form.form({
            url: form.attr("action"),
            locked: true
        });
        var btn = form.find("button:not([data-toggle])");
        btn.click(function() {
            form.data("doc").send(function() {
				UserForm.after();
            });
			UserForm.before();
        });
    },
    before: function() {
        $("#user-login-form").parents(".page-block").append(
            $("<img>", {
                src: "img/ajax-loader.gif",
                css: {
                    "width": "100px",
                    "height": "100px",
                    "position": "absolute",
                    "left": "calc(50% - 35px)",
                    "bottom": "calc(50% - 50px)",
                    "z-index": "2",
                    "capacity": "1"
                },
                "class": "loading-image"
            }).fadeIn("slow")
        ).find("*:not(.loading-image)").fadeOut("slow");
    },
    after: function() {
        var block = $("#user-login-form").parents(".page-block");
        block.find(".loading-image").promise().done(function() {
			$(this).fadeOut("slow");
		});
        block.find("*:not(.loading-image)").promise().done(function() {
			$(this).fadeIn("slow");
		});
    }
};

$(document).ready(function() {
    UserForm.construct();
});