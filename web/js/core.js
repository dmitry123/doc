var Core = Core || {};

(function(Core) {

    "use strict";

    /**
     * Extend child class with parent
     * @param child {function} - Child class
     * @param parent {function} - Parent class
     * @returns {function} - Child class
     */
    Core.extend = function(child, parent) {
        var F = function() {};
        F.prototype = parent.prototype;
        child.prototype = new F();
        child.prototype.constructor = child;
        child.superclass = parent.prototype;
        return child;
    };

    /**
     * Construct component
	 * @param properties {{}} - Object with properties
     * @param [defaults] {{}|null|undefined} - Default component's properties
     * @param [selector] {jQuery|null|undefined} - Component's selector or nothing
     * @constructor
     */
    var Component = function(properties, defaults, selector) {
		if (typeof (this._name = properties["<plugin>"]) !== "string") {
			throw new Error("Can't resolve component's plugin name as string, found \"" + typeof this._name + "\"");
		}
        this._properties = $.extend(
            defaults || {}, properties || {}
        );
        this._selector = selector || this.render();
    };

	/**
	 * That method returns name of data attribute for
	 * current component
	 * @returns {string} - Attribute name
	 */
	Component.prototype.getDataAttribute = function() {
		if (!this._name) {
			throw new Error("Component hasn't been registered as jQuery plugin");
		} else {
			return this._name;
		}
	};

    /**
     * Override that method to return jquery item
     */
    Component.prototype.render = function() {
        throw new Error("Component/render() : Not-Implemented");
    };

    /**
     * Override that method to activate just created jQuery item
     */
    Component.prototype.activate = function() {
        /* Ignored */
    };

    /**
     * Override that method to provide some actions before update
     */
    Component.prototype.before = function() {
        /* Ignored */
    };

    /**
     * Override that method to provide some actions after update
     */
    Component.prototype.after = function() {
        /* Ignored */
    };

    /**
     * Set/Get component's jquery selector
     * @param [selector] {jQuery} - New jquery to set
     * @returns {jQuery} - Component's jquery
     */
    Component.prototype.selector = function(selector) {
        if (arguments.length > 0 && selector !== void 0) {
			if (!(selector instanceof jQuery)) {
				throw new Error("Selector must be an instance of jQuery object");
			}
            if (!selector.data(this.getDataAttribute())) {
                selector.data(this.getDataAttribute(), this);
            }
            this._selector = selector;
        }
        return this._selector;
    };

    /**
     * Get/Set some property
     * @param key {string} - Property key
     * @param value  {*} - Property value
     * @returns {*} - New or old property's value
     */
    Component.prototype.property = function(key, value) {
        if (arguments.length > 1) {
            this._properties[key] = value;
        }
        return this._properties[key];
    };

    /**
     * Override that method to destroy you component or
     * it will simply remove selector
     */
    Component.prototype.destroy = function() {
		$.removeData(this.selector(), this.getDataAttribute());
    };

    /**
     * Update method, will remove all selector, render
     * new, activate it and append to previous parent
     */
    Component.prototype.update = function() {
        this.before();
        this.selector().replaceWith(
            this.selector(this.render())
        );
        this.after();
        this.activate();
    };

	/**
	 * Common class with static helper methods
	 * @constructor
	 */
	var Common = function() {
	};

	/**
	 * Cleanup component's value and all errors or warnings
	 * @param component
	 */
	Common.cleanup = function(component) {
		$(component).find(".form-group")
			.removeClass("has-error")
			.removeClass("has-warning")
			.removeClass("has-success");
		$(component).find("select:not([multiple][data-cleanup!='false'])").each(function(i, item) {
			$(item).val($(item).find("option:eq(0)").val());
		});
		var list = [ "input", "textarea", "select[multiple]" ];
		for (var i in list) {
			list[i] += "[data-cleanup!='false']";
		}
		$(component).find(list.join(",")).val("");
	};

	/**
	 * Get url to get widget component
	 * @returns {String} - Path to widget action
	 * @static
	 */
	Common.getWidget = function() {
		return window["doc"]["widget"];
	};

	Core.sendAjax = function(method, href, data, success) {
		return $[method.toLowerCase()](href, data, function(json) {
			if (!json["status"]) {
				if (json["error"] !== "form") {
					return Core.createMessage({
						message: json["message"]
					});
				}
			} else if (json["message"]) {
				Core.createMessage({
					message: json["message"],
					type: "success",
					sign: "ok"
				});
			}
			success && success(json);
		}, "json").fail(function() {
			return Core.createMessage({
				message: "Произошла ошибка при обработке запроса. Обратитесь к администратору"
			});
		});
	};

	Core.sendQuery = function(href, data, success) {
		return Core.sendAjax("get", url(href), data, success);
	};

	Core.sendPost = function(href, data, success) {
		return Core.sendAjax("post", url(href), data, success);
	};

	Core.postFormErrors = function(where, json) {
		var html = $("<ul>");
		for (var i in json["errors"] || []) {
			where.find("[id='" + i + "']").parents(".form-group").addClass("has-error");
			for (var j in json["errors"][i]) {
				$("<li>", {
					text: json["errors"][i][j]
				}).appendTo(html);
			}
		}
		return Core.createMessage({
			message: json["message"] + html.html(),
			delay: 10000
		});
	};

	Core.loadWidget = function(widget, attributes, success, module) {
		return Core.sendQuery("ext/widget", {
            "module": module || doc["module"],
			"class": widget,
            "config": attributes
		}, function(response) {
			success && success(response["component"]);
		});
	};

	Core.loadPanel = function(widget, attributes, success) {
		return Core.sendQuery("ext/panel", $.extend(attributes, {
			widget: widget
		}), success);
	};

	Core.loadTable = function(widget, provider, config, success) {
		return $.ajax({
			url: url("ext/table"),
			data: {
				widget: widget,
				provider: provider,
				config: config
			},
			dataType: "json",
			cache: false
		}).done(function(response) {
			if (!response["status"]) {
				if (response["error"] !== "form") {
					return Core.createMessage({
						message: response["message"]
					});
				}
			} else if (response["message"]) {
				Core.createMessage({
					message: response["message"],
					type: "success",
					sign: "ok"
				});
			}
			success && success(response);
		}).fail(function() {
			return Core.createMessage({
				message: "Произошла ошибка при обработке запроса. Обратитесь к администратору"
			});
		});
	};

	Core.loadExt = function(module, ext, params, success) {
		return Core.sendQuery("ext/load", {
			module: module,
			ext: ext,
			params: params
		}, success);
	};

	Core.resetFormErrors = function(where) {
		$(where).find(".form-group").removeClass("has-error");
	};

	Core.Component = Component;
	Core.Common = Common;

	/**
	 * Create new component, which extends basic
	 * Component class
	 * @param component {Function} - New component class
	 * @returns {Function} - Same component instance
	 */
	Core.createComponent = function(component) {
		return Core.extend(component, Component);
	};

	/**
	 * Create new sub-component, which extends basic
	 * SubComponent class
	 * @param component {Function} - New component class
	 * @returns {Function} - Same component instance
	 */
	Core.createSubComponent = function(component) {
		return Core.extend(component, SubComponent);
	};

    /**
     * Create new component's instance and render to DOM
     * @param component {Component|Object} - Component's instance
     * @param selector {HTMLElement|string} - Parent's selector
     * @param [update] {Boolean} - Update component or not (default yes)
     */
    Core.createObject = function(component, selector, update) {
        $(selector).data(component.getDataAttribute(), component).append(
            component.selector()
        );
        if (update !== false) {
            component.update();
        } else {
            component.activate();
        }
        return component;
    };

	/**
	 * Create plugin for component
	 * @param plugin {String} - Name of jQuery plugin {@see Component#getDataAttribute}
	 * @param func {Function} - Function that registers component
	 * @static
	 */
	Core.createPlugin = function(plugin, func) {
		var attr = "core-" + plugin;
		var register = function(me, options, args, ret) {
			var r, a = [], s;
			for (var i in args) {
				if (i > 0) {
					a.push(args[i]);
				}
			}
			if (options !== void 0 && typeof options == "string") {
				var c = me.data(attr);
				if (!c) {
					if (!(c = register(me, {}, [], true))) {
						throw new Error("Component hasn't been initialized, create it first");
					}
					me.data(attr, c);
				}
				if (c[options] == void 0) {
					throw new Error("That component doesn't implement method \"" + options + "\"");
				}
				if ((r = c[options].apply(c, a)) !== void 0) {
					return r;
				}
			} else {
				if (me.data(attr) != void 0) {
					return void 0;
				}
				if (typeof me != "function") {
					if (me.length) {
						s = me[0];
					} else {
						s = me.selector;
					}
					r = func(s, $.extend(options, {
						"<plugin>": attr
					}));
				} else {
					r = func($.extend(options, {
						"<plugin>": attr
					}));
				}
				if (ret) {
					return r;
				}
			}
			return void 0;
		};
		return $.fn[plugin] = function(options) {
			var t;
			var args = arguments || [];
			if (this.length > 1) {
				var r = [];
				this.each(function(it, me) {
					if ((t = register($(me), options, args)) !== void 0) {
						r.push(t);
					}
				});
				if (r.length > 0) {
					return r;
				}
			} else {
				if ((t = register($(this), options, args)) !== void 0) {
					return t;
				}
			}
			return this;
		};
	};

	/**
	 * Create callback on ready event, which will be invoked
	 * after DOM load and any success ajax request
	 * @param func {Function} - Function to execute
	 */
	Core.ready = function(func) {
		$(document).ready(func);
		$(document).bind("ajaxSuccess", func);
	};

	/**
	 * Generate url based on Yii's base url
	 *
	 * @param url {String} relative url
	 * @param [params] object with url parameters
	 *
	 * @returns {String} absolute url
	 */
    window.url = function(url, params) {
		url = url || "";
        if (window["doc"]["url"] == "/" && url.charAt(0) !== "/") {
			url = window["doc"]["url"] + url;
        } else if (url.charAt(0) != "/") {
			url = window["doc"]["url"] + "/" + url;
        }
        url = url.replace(/\/{2,}/, "/");
		if (!params) {
			return url;
		}
		url += "?";
		for (var i in params) {
			url += i + "=" + params[i] + "&";
		}
		return url.replace(/&$/, "");
    };

	window.selected = function() {
		var text = "";
		if (window.getSelection) {
			text = window.getSelection().toString();
		} else if (document.selection && document.selection.type != "Control") {
			text = document.selection.createRange().text;
		}
		return text;
	};

	window.getQuery = function(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	};

	window.serialize = function(obj, prefix) {
		var str = [];
		for(var p in obj) {
			if (obj.hasOwnProperty(p)) {
				var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
				str.push(typeof v == "object" ?
					serialize(v, k) :
				encodeURIComponent(k) + "=" + encodeURIComponent(v));
			}
		}
		return str.join("&");
	};

	jQuery.fn.path = function(root) {
		root = root || $("html");
		if (this.length != 1) {
			throw new Error("Requires one element");
		}
		var path = null,
			node = this;
		while (node.length) {
			var realNode = node[0],
				name = realNode.localName;
			if (!name || realNode == $(root)[0]) {
				break;
			}
			name = name.toLowerCase();
			var parent = node.parent();
			var siblings = parent.children(name);
			if (siblings.length > 1) {
				name += ':eq(' + siblings.index(realNode) + ')';
			}
			path = name + (path ? '>' + path : '');
			node = parent;
		}
		return path;
	};

	$.fn.rotate = function(angle, duration, easing, deg, complete) {
		var args = $.speed(duration, easing, deg, complete);
		var step = args.step;
		deg = deg || 0;
		return this.each(function(i, e) {
			args.complete = $.proxy(args.complete, e);
			args.step = function(now) {
				$.style(e, 'transform', 'rotate(' + now + 'deg)');
				if (step) return step.apply(e, arguments);
			};
			$({deg: deg}).animate({deg: angle}, args);
		});
	};

	$.fn.cleanup = function() {
		return this.each(function(i, e) {
			Common.cleanup(e);
		});
	};

})(Core);

var AssetManager = {
	loadScript: function(file, callback) {
		file = url(file);
		if (this.file[file] || $("script").filter("[src='"+ file +"']").length > 0) {
			callback && callback();
			return void 0;
		} else {
			this.file[file] = true;
		}
		$.getScript(file, callback);
	},
	loadStyle: function(file, callback) {
		file = url(file);
		if (this.file[file] || $("link").filter("[href='"+ file +"']").length > 0) {
			callback && callback();
			return void 0;
		} else {
			this.file[file] = true;
		}
		var style = $("<link>", {
			rel: "stylesheet",
			type: "text/css",
			href: file
		}).load(function() {
			callback && callback();
		});
		$('head').append(style);
	},
	file: {}
};

$(document).ready(function() {
	$(document).on('show.bs.modal', '.modal', function(e) {
		if (!$(e.target).hasClass("modal")) {
			return void 0;
		}
		var depth = 1142 + (10 * $('.modal:visible').length);
		$(this).find(".modal-dialog").css('z-index', depth);
		setTimeout(function() {
			$('.modal-backdrop').not('.modal-stack').css('z-index', depth - 1).addClass('modal-stack');
		}, 0);
	});
});