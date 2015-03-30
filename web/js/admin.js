
var TablePanel = {
	ready: function() {
        $(".admin-table-panel-wrapper").on("click", "#table-save-button", function() {
            $("#table-save-modal").modal();
        });
	},
	load: function(table, after) {
		$.get(url("admin/table/load"), {
			table: table
		}, function(json) {
			if (!json["status"]) {
				return Doc.createMessage({
					message: json["message"]
				});
			}
			$(".admin-table-panel-wrapper")
				.empty().append(json["component"]);
			after && after.call();
		}, "json");
	}
};

var TableView = {
	ready: function() {
		var me = this;
		$(".table-panel-wrapper li[data-table] a").click(function() {
			var that = this;
            var table = $(this).parent().data("table");
            if (!table) {
                return void 0;
            }
			var image;
			$(this).append(image = $("<img>", {
				src: "../img/ajax-loader.gif",
				css: {
					"height": "20px"
				}
			}).fadeIn("fast"));
			TablePanel.load(table, function() {
				me.toggle($(that).parent().children(".table-column-list"));
				image.fadeOut("fast", function() {
					$(this).remove();
				});
			});
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
        $(".table-widget").on("click", ".edit", function() {
            var id = $(this).parents("tr[data-id]").data("id");
            console.log(id);
        });
        $(document).on("click", ".table-widget .delete", function() {
            var id = $(this).parents("tr[data-id]").data("id");
            console.log(id);
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
	TablePanel.ready();
	TableView.ready();
});