var Core = Core || {};

(function(Core) {

	"use strict";

	var Table = Core.createComponent(function(properties, selector) {
		Core.Component.call(this, properties, {
			updateDelay: 250
		}, selector);
	});

	Table.prototype.update = function() {
		var config, me = this, table = this.selector();
		if (this.selector().trigger("table.update") === false) {
			return void 0;
		}
		this.before();
		if (config = table.attr("data-config")) {
			config = $.parseJSON(config);
			for (var i in config) {
				this.configure(i, config[i], false);
			}
		}
		config = this.property("config") || {};
		Core.loadTable(table.attr("data-widget"), table.attr("data-provider"), config, function(response) {
			me.after(function() {
				me.selector().replaceWith($(response["component"]).data(me.getDataAttribute(), me));
				me.selector().trigger("table.updated");
			});
		}).fail(function() {
			me.after();
		});
	};

	Table.prototype.configure = function(attribute, properties, strong) {
		var config = this.property("config") || {},
			scope = config[attribute] || {};
		if (strong === void 0) {
			strong = true;
		}
		for (var key in properties) {
			if (scope[key] && !strong) {
				continue;
			}
			scope[key] = properties[key];
		}
		config[attribute] = scope;
		this.property("config", config);
		return this;
	};

	Table.prototype.before = function(callback) {
		this.selector().loading("render", callback);
	};

	Table.prototype.after = function(callback) {
		this.selector().loading("destroy", callback);
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
		this.configure("sort", {
			orderBy: order
		}).update();
	};

	Table.prototype.page = function(page) {
		this.configure("pagination", {
			page: page
		}).update();
	};

	Table.prototype.limit = function(limit) {
		this.configure("pagination", {
			pageSize: limit
		}).update();
	};

	Core.createPlugin("table", function(selector, properties) {
		var t;
		if ($(selector).get(0).tagName != "TABLE") {
			if ((t = $(selector).parents("table")).length != 0) {
				selector = t.get(0);
			} else {
				return void 0;
			}
		}
		return Core.createObject(new Table(properties, $(selector)), selector, false);
	});

})(Core);