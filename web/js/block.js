
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
		var me = this;
		this.padding = parseInt($(".page-block").css("padding")) * 2;
		$.get(link || url(""), {}, function(html) {
			var native = $(".page-block");
			var page = $(html).find(".page-block");
			var c;
			$(document.body).append(c = page.hide());
			c.find("[data-load='block']").each(function(i, b) {
				console.log(b);
				$(document.body).append(b);
			});
			native.animate({
				height: c.height() + me.padding,
				width: c.width() + me.padding
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
		var content = $(".page-block");
		content.css({
			"height": content.height() + this.padding,
			"width": content.width() + this.padding
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
				}, 100);
			}, "json");
		});
		$(document).on("click", ".settings-button", function() {
			PageReload.before();
			PageReload.reload(url("site/settings"));
		});
		$(document).on("click", ".modules-button", function() {
			PageReload.before();
			PageReload.reload(url("site/index"));
		});
		$(document).on("click", ".module-icon-wrapper", function() {
			var url;
			if ((url = $(this).data("url")) == void 0) {
				return void 0;
			}
			window.location.href = url;
		});
	}
};

$(document).ready(function() {
    UserForm.ready();
	ModuleForm.ready();
});