
var BlockPageManager = {
	reload: function(link, auto) {
		var me = this;
		var block = $(".page-block");
		if (auto === void 0 || auto === true) {
			this.before();
		}
		$.get(url(link) || url(""), {}, function(html) {
			var native = $(".page-block");
			var page = $(html).find(".page-block");
			var c;
			native.css({
				width: me.width,
				height: me.height
			});
			$(document.body).append(c = page.hide());
			native.animate({
				"height": c.height() + me.padding,
				"width": c.width() + me.padding
			}, "fast", function() {
                native.replaceWith(c.show());
                c.children().hide().fadeIn("fast");
			});
			$(".loading-image").fadeOut("fast");
		});
	},
	before: function() {
		var content = $(".page-block"),
            image;
		this.padding = parseInt(content.css("padding")) * 2;
		this.width = +content.width() + this.padding;
		this.height = +content.height() + this.padding;
		content.css({
			"height": +content.height() + this.padding,
			"width": +content.width() + this.padding
		}).append(
			image = $("<img>", {
				src: "img/ajax-loader.gif",
				css: {
					"width": "100px",
					"height": "100px",
					"position": "absolute",
					"left": "calc(50% - 50px)",
					"bottom": "calc(50% - 50px)",
					"z-index": "2"
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

$(document).ready(function() {

	$(document).on("click", "#login-button", function() {
		BlockPageManager.before();
		$("#user-login-form").form({
			success: function(response) {
				BlockPageManager.reload(response["redirect"], false);
			},
			fail: function() {
				BlockPageManager.after();
			}
		}).form("send");
	}).on("click", "#register-button", function() {
		BlockPageManager.reload("site/register");
	});

	$(document).on("click", ".register-save-button", function() {
		BlockPageManager.before();
		$("#user-register-form").form({
			success: function() {
				BlockPageManager.reload("site/index", false);
			},
			fail: function() {
				BlockPageManager.after();
			}
		}).form("send");
	}).on("click", ".register-cancel-button", function() {
		BlockPageManager.reload();
	});

	$(document).on("click", ".modules-logout-button, .employee-logout-button", function() {
		Core.sendPost("user/logout", null, function() {
			BlockPageManager.reload();
		});
	}).on("click", ".modules-settings-button", function() {
		BlockPageManager.reload("site/settings");
	}).on("click", ".settings-back-button", function() {
		BlockPageManager.reload("site/index");
	}).on("click", ".error-main-button", function() {
		BlockPageManager.reload("site/index");
	}).on("click", ".module-icon-wrapper", function() {
		if ($(this).data("url") !== void 0) {
			window.location.href = $(this).data("url");
		}
	});
});