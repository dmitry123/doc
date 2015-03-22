
var UserForm = {
    ready: function() {
		$(document).on("click", "#login-button", function() {
			var f = $("#user-login-form");
			f.form({
				url: f.attr("action"),
				locked: true
			}).form("send", function(f, s, j) {
				if (s == true) {
					PageReload.reload();
				} else {
					PageReload.after();
				}
			});
			PageReload.before();
		});
    }
};

var PageReload = {
	reload: function(link) {
		$.get(link || url(""), {}, function(html) {
			var native = $(".page-block");
			var page = $(html).find(".page-block");
			var c;
			$(document.body).append(
				c = page.clone().hide()
			);
			native.animate({
				height: c.height() + 80,
				width: c.width() + 80
			}, "fast", function() {
				native.replaceWith(c.show());
				c.children(".page-content").hide().fadeIn("fast");
			});
			$(".loading-image").promise().done(function() {
				$(this).fadeOut("fast");
			});
		});
	},
	before: function() {
		var page = $(".page-block");
		page.css({
			"height": page.height() + 80,
			"width": page.width() + 80
		}).append(
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
		var block = $(".page-block");
		block.find(".loading-image").promise().done(function() {
			$(this).fadeOut("slow");
		});
		block.find("*:not(.loading-image)").promise().done(function() {
			$(this).fadeIn("slow");
		});
	}
};

var ModuleForm = {
	ready: function() {
		$(document).on("click", ".block-logout", function() {
			PageReload.before();
			$.post(url("user/logout"), [], function(json) {
				setTimeout(function() {
					PageReload.reload(json["url"]);
				}, 250);
			}, "json");
		});
	}
};

$(document).ready(function() {
    UserForm.ready();
	ModuleForm.ready();
});