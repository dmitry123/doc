
var Plantation_Master_ModuleMenu = {
	ready: function() {
		var me = this;
		$("#plantation-master-menu").on("click", ".nav li > a", function() {
			window.location.hash = $(this).attr("data-module");
			me.loadExt($(this).attr("data-module"));
		});
		if (window.location.hash.length > 1) {
			this.loadExt(window.location.hash.substr(1));
		}
	},
	loadExt: function(module) {
		var me = this;
		var menu = $("#plantation-master-menu");
		me.loading = $("<div>", {
			class: "col-xs-12 text-center"
		}).css({
			"margin-top": menu.height() / 2 - 80
		}).append($("<img>", {
			src: url("img/ajax-loader-2.gif"),
			height: "160px"
		})).fadeIn("normal");
		var body = menu.parents(".master-menu-wrapper:eq(0)").find(".master-menu-body:eq(0)")
			.empty().append(me.loading);
		Core.loadExt(module, "plantation", function(response) {
			me.loading.fadeOut("normal", function() {
				var t = $(response["component"]);
				t.children("*:not(.modal)").hide();
				body.append(t);
				t.children("*:not(.modal)").hide().fadeIn("normal");
			});
		}).fail(function() {
			me.showMessage("Модуль не выбран");
		}).success(function(response) {
			if (!response["status"]) {
				return me.showMessage(response["message"]);
			}
		});
	},
	showMessage: function(message) {
		this.loading.fadeOut("normal", function() {
			$(this).parents(".master-menu-wrapper:eq(0)")
				.find(".master-menu-body:eq(0)")
				.empty().append($("<h1>", {
					class: "text-center",
					text: message
				}).fadeIn("normal")
			);
		});
		return void 0;
	},
	loading: null
};

$(document).ready(function() {
	Plantation_Master_ModuleMenu.ready();
});