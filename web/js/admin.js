
var TableViewer = {
	ready: function() {
	},
	load: function(table) {
		$.get(url("admin/table/load"), {
			table: table
		}, function(json) {
			if (!json["status"]) {
				Doc.createMessage({
					message: json["message"]
				});
			} else {
				$(".table-widget").empty().append(
					json["component"]
				);
			}
		}, "json");
	}
};

var TableList = {
	ready: function() {
		var me = this;
		$(".table-panel-wrapper li a").click(function() {
			TableViewer.load($(this).parent().data("table"));
			me.toggle($(this).parent().children(".table-column-list"));
		});
	},
	toggle: function(menu) {
		if (menu.css("display") != "none") {
			return this.collapse(menu);
		} else {
			return this.expand(menu);
		}
	},
	expand: function(menu) {
		var me = this;
		if (menu.css("display") == "none") {
			menu.slideDown();
		} else {
			return false;
		}
		$(".table-panel-wrapper li .table-column-list").each(function(i, m) {
			if (m != menu[0]) {
				me.collapse($(m));
			}
		});
		$(menu.parent().find(".glyphicon")[0]).fadeOut(200, function() {
			$(this).replaceWith($("<span>", {
				class: "glyphicon glyphicon-collapse-down"
			}).fadeIn(200));
		});
		return true;
	},
	collapse: function(menu) {
		if (menu.css("display") != "none") {
			menu.slideUp();
		} else {
			return false;
		}
		$(menu.parent().find(".glyphicon")[0]).fadeOut(200, function() {
			$(this).replaceWith($("<span>", {
				class: "glyphicon glyphicon-unchecked"
			}).fadeIn(200));
		});
		return true;
	}
};

$(document).ready(function() {
	TableViewer.ready();
	TableList.ready();
});