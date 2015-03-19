
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
		$(".table-panel-wrapper li[data-table] a").click(function() {
            var table = $(this).parent().data("table");
            if (!table) {
                return void 0;
            }
			TableViewer.load(table);
			me.toggle($(this).parent().children(".table-column-list"));
            window.location.hash = "#" + table;
		});
        if (window.location.hash != "") {
            var h = window.location.hash.substr(1).split("/");
            $("li[data-table='" + h[0] + "'] a").trigger("click");
            if (h.length > 1) {
                $("li[data-column='" + h[1] + "']").trigger("click");
            }
        } else {
            $("li[data-table='user']").trigger("click");
        }
        $(".table-column-list li[data-column]").click(function() {
            var column = $(this).data("column");
            // ignore
            window.location.hash = window.location.hash.split("/")[0]
                + "/" + column;
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