var Doc = Doc || {};

(function(Core) {

	"use strict";

	var Table = Core.createComponent(function(properties, selector) {
		Core.Component.call(this, properties, {
			page: 1
		}, selector);
	});

	Table.prototype.update = function(parameters) {
		var me = this, table = this.selector();
		parameters = $.extend({
			currentPage: this.property("page"),
			orderBy: this.property("order"),
			pageLimit: this.property("limit")
		}, parameters);
		this.before();
		$.get(this.selector().data("url"), $.extend({
			class: table.data("class"),
			condition: table.data("condition"),
			params: table.data("parameters"),
			pageLimit: table.data("limit")
		}, parameters), function(json) {
			if (!json["status"]) {
				return Core.createMessage({
					message: json["message"]
				});
			}
			me.selector().replaceWith(
				$(json["component"]).data("doc", me)
			);
		}, "json").always(function() {
			me.after();
		});
	};

	Table.prototype.fetch = function(properties) {
		for (var key in properties) {
			this.property(key, properties[key]);
		}
		this.update();
	};

	Table.prototype.order = function(key) {
		var order, g, match;
		if ((g = this.selector().find(".table-order")).length > 0) {
			if (g.hasClass("table-order-desc")) {
				order = g.parents("td").data("key") + " desc";
			} else {
				order = g.parents("td").data("key");
			}
			match = order.split(" ");
			if (key == match[0]) {
				if (match[1] == "desc") {
					order = match[0];
				} else {
					order = match[0] + " desc";
				}
			} else {
				order = key;
			}
		} else {
			order = key;
		}
		this.fetch({
			order: order
		});
	};

	Table.prototype.page = function(page) {
		this.fetch({
			page: +page
		});
	};

	Table.prototype.limit = function(limit) {
		this.fetch({
			limit: +limit
		});
	};

	Core.createTable = function(selector, properties) {
		var t;
		if ($(selector).get(0).tagName != "TABLE") {
			if ((t = $(selector).parents("table")).length != 0) {
				selector = t.get(0);
			} else {
				return void 0;
			}
		}
		return Core.createObject(new Table(properties, $(selector)), selector, false);
	};

	$.fn.table = Core.createPlugin("createTable");

})(Doc);