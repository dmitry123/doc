
var Admin_Table_TablePanel = {
	ready: function() {
        $(".admin-table-panel-wrapper").on("click", "#table-save-button", function() {
            $("#table-save-modal").modal();
        });
	},
	load: function(table, success) {
		$.get(url("admin/table/load"), {
			table: table
		}, function(json) {
			if (!json["status"]) {
				return Core.createMessage({
					message: json["message"]
				});
			}
			$("#admin-table-view-panel .panel-body")
				.empty().append(json["component"]);
			success && success.call();
		}, "json");
	}
};

var Admin_Table_TableMenu = {
	ready: function() {
		var me = this;
		$("#admin-table-menu").on("click", "li > a", function() {
			var that = this,
				table = $(this).parent().attr("data-table"),
				form = $(this).parent().attr("data-form"),
				model = $(this).parent().attr("data-model");
			var image;
			if (!table || !form || !model) {
				return Core.createMessage({
					message: "Не реализовано"
				});
			}
			$("#admin-table-view-panel").attr("data-attributes", JSON.stringify({
				model: model,
				form: form
			}));
			$(this).append(image = $("<img>", {
				src: url("img/ajax-loader.gif"),
				css: {
					"height": "20px"
				}
			}).fadeIn("fast"));
			Admin_Table_TablePanel.load(table, function() {
				me.toggle($(that).parent().children(".table-column-list"));
				image.fadeOut("fast", function() {
					$(this).remove();
				});
			});
			window.location.hash = "#" + table;
		});
        if (window.location.hash != "") {
            var h = window.location.hash.substr(1).split("/");
            $("li[data-table='" + h[0] + "'] > a").trigger("click");
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
		$(".table-list li .table-column-list").each(function(i, m) {
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
	Admin_Table_TablePanel.ready();
	Admin_Table_TableMenu.ready();
});