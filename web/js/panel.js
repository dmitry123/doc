var Core = Core || {};

(function(Core) {

	"use strict";

	var Panel = Core.createComponent(function(properties, selector) {
		Core.Component.call(this, properties, {
			velocity: "fast"
		}, selector);
	});

	Panel.prototype.collapse = function() {
		this.selector().find(".panel-body").slideUp(
			this.property("velocity")
		);
		this.selector().find(".panel-collapse-button")
			.rotate(180, 500, 'swing', 0);
	};

	Panel.prototype.expand = function() {
		this.selector().find(".panel-body").slideDown(
			this.property("velocity")
		);
		this.selector().find(".panel-collapse-button")
			.rotate(360, 500, "swing", 180);
	};

	Panel.prototype.toggle = function() {
		if (this.selector().find(".panel-body").is(":visible")) {
			this.collapse();
		} else {
			this.expand();
		}
	};

	Panel.prototype.before = function() {
		var refresh = this.selector().loading("render").find(".panel-update-button");
		if (refresh[0].tagName != "SPAN") {
			refresh.children(".glyphicon").rotate(360, 500, "swing");
		} else {
			refresh.rotate(360, 500, "swing");
		}
		this.selector().trigger("panel.update");
	};

	Panel.prototype.after = function() {
		this.selector().trigger("panel.updated");
		this.selector().loading("destroy");
	};

	Panel.prototype.update = function() {
		var widget, me = this;
		if (!(widget = this.selector().attr("data-widget"))) {
			return void 0;
		} else if (!Core.Common.getWidget()) {
			throw new Error("Layout hasn't declared [doc::widget] field via [Widget::createUrl] method");
		}
		this.before();
		var params = $.parseJSON(this.selector().attr("data-attributes"));
		if (params.length !== void 0 && !params.length) {
			params = {};
		}
		Core.loadPanel(this.selector().attr("data-widget"), {
			config: params
		}, function(response) {
			me.selector().find(".panel-content").fadeOut("fast", function() {
				$(this).empty().append(response["component"]).hide().fadeIn("fast");
			});
		}).always(function() {
			me.after();
		});
	};

	$.fn.panel = Core.createPlugin("panel", function(selector, properties) {
		var t;
		if (!$(selector).hasClass("panel")) {
			if ((t = $(selector).parents(".panel:eq(0)")).length != 0) {
				selector = t.get(0);
			} else {
				return void 0;
			}
		}
		return Core.createObject(new Panel(properties, $(selector)), selector, false);
	});

})(Core);