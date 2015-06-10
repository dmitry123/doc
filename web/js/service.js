
var Admin_ModuleMenu_TabMenu = {
	ready: function() {
		var me = this, menu = $("#service-module-menu");
		menu.find("li > ul > li > a").click(function() {
			me.load($(this).parents("ul:eq(0)").prev().attr("data-module"), $(this).attr("data-ext"));
		});
		$(".service-refresh-icon").click(function() {
			menu.find("li > ul > li.active > a").trigger("click");
			$(this).rotate(360, 500, "swing");
		});
	},
	load: function(module, id) {
		var container = $("#service-module-content"),
			menu = $("#service-module-menu");
		var body = menu.parents(".panel").find(".panel-body").loading({
			image: url("img/ajax-loader-2.gif")
		}).loading("render");
		var bar = $("#service-module-progress").children(".progress-bar");
		var t = bar.css("transition");
		bar.css("transition", "width 0s linear 0s");
		bar.css("width", "0");
		setTimeout(function() {
			bar.css("transition", t);
		}, 0);
		var step = 0, total = 1;
		var progress = function() {
			bar.css({ "width": ((++step) / total * 100) + "%" });
			if (step == total - 1) {
				progress();
			}
		};
		Core.loadExt(module, "service/" + id, {}, function(response) {
			container.empty().append(response["component"]);
			menu.find("li > ul > li.active").removeClass("active");
			menu.find("li > ul > li > a[data-ext='"+ id +"']").parents("li:eq(0)").addClass("active");
			var requires = response["requires"];
			if (requires && requires["js"]) {
				var js = requires["js"];
				total += js.length ? js.length : 0;
				for (var i in js) {
					AssetManager.loadScript(js[i], progress);
				}
			}
			if (requires && requires["css"]) {
				var css = requires["css"];
				total += css.length ? css.length : 0;
				for (var j in css) {
					AssetManager.loadStyle(css[j], progress);
				}
			}
		}).always(function() {
			body.loading("reset");
		});
	}
};

$(document).ready(function() {
	Admin_ModuleMenu_TabMenu.ready();
});