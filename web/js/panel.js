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
		this.selector().loading("render");
		var refresh = this.selector().find(".panel-update-button");
        if (!refresh.length) {
            return void 0;
        }
		if (refresh[0].tagName != "SPAN") {
			refresh.children("span").rotate(360, 500, "swing");
		} else {
			refresh.rotate(360, 500, "swing");
		}
	};

	Panel.prototype.after = function() {
		this.selector().loading("reset");
	};

	Panel.prototype.update = function() {
		var widget, me = this;
		if (!(widget = this.selector().attr("data-widget"))) {
			return void 0;
		} else if (!Core.Common.getWidget()) {
			throw new Error("Layout hasn't declared [doc::widget] field via [Widget::createUrl] method");
		}
		this.before();
		if (this.selector().find(".panel-content > *:eq(0)").is("table")) {
			this.selector().find(".panel-content > table").table("update");
			this.after();
			this.selector().trigger("panel.updated");
			return void 0;
		}
        var params = this.selector().attr("data-attributes");
        if (params) {
            params = $.parseJSON(params);
        } else {
            params = {};
        }
		if (params.length !== void 0 && !params.length) {
			params = {};
		}
        this.selector().trigger("panel.update");
		Core.loadPanel(this.selector().attr("data-widget"), {
			config: params
		}, function(response) {
			me.selector().find(".panel-content").fadeOut("fast", function() {
				$(this).empty().append(response["component"]).hide().fadeIn("fast");
			});
            me.selector().trigger("panel.updated");
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