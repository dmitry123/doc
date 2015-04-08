var Doc = Doc || {};

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
		this._properties = $.extend(
			defaults || {}, properties || {}
		);
		this._selector = selector || this.render();
	};

	/**
	 * Override that method to return jquery item
	 */
	Component.prototype.render = function() {
		throw new Error("Component/render() : Not-Implemented");
	};

	/**
	 * Override that method to activate just created jquery item
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
		if (arguments.length > 0) {
			if (!selector.data("doc")) {
				selector.data("doc", this);
			}
			this._selector = selector;
		}
		return this._selector;
	};

	/**
	 * Get/Set some property
	 * @param key {string} - Property key
	 * @param [value]  {*} - Property value
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
		throw new Error("That component doesn't support downgrade");
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
		this.selector().data("doc", this);
		this.after();
		this.activate();
	};

	/**
	 * Sub-Component class, use it to declare sub component, that instance
	 * won't be rendered automatically, you shall manually invoke render method
	 * @param component {Component} - Parent component
	 * @param [selector] {jQuery} - jQuery's selector or null
	 * @constructor
	 */
	var SubComponent = function(component, selector) {
		this.component = function() {
			return component;
		};
		Component.call(this, {}, {}, selector || true);
	};

	Core.extend(SubComponent, Component);

	/**
	 * That method will fetch properties values from
	 * parent's component
	 * @param key {String} - Property name
	 * @param value {*} - Property value
	 */
	SubComponent.prototype.property = function(key, value) {
		return this.component().property.apply(this.component(), arguments);
	};

	/**
	 * Common class with static helper methods
	 * @constructor
	 */
	var Common = function() {
	};

	/**
	 * Cleanup component's value and all errors or warnings
	 * @static
	 * @param component
	 */
	Common.cleanup = function(component) {
		$(component).find(".form-group").removeClass("has-error")
			.removeClass("has-warning").removeClass("has-success");
		$(component).find("select:not([multiple])").each(function(i, item) {
			$(item).val($(item).find("option:eq(0)").val());
		});
		$(component).find("input, textarea, select[multiple]").val("");
	};

	Core.Component = Component;
	Core.SubComponent = SubComponent;
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
	 * @static
	 */
	Core.createObject = function(component, selector, update) {
		$(selector).data("doc", component).append(
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
	 * @param func {String} - Name of create function, for example 'createMessage'
	 * @static
	 */
	Core.createPlugin = function(func) {
		var register = function(me, options, args, ret) {
			var r;
			var a = [];
			for (var i in args) {
				if (i > 0) {
					a.push(args[i]);
				}
			}
			if (options !== void 0 && typeof options == "string") {
				var c = me.data("doc");
				if (!c) {
					if (!(c = register(me, {}, [], true))) {
						throw new Error("Component hasn't been initialized, create it first");
					}
					me.data("doc", c);
				}
				if (c[options] == void 0) {
					throw new Error("That component don't resolve method \"" + options + "\"");
				}
				if ((r = c[options].apply(c, a)) !== void 0) {
					return r;
				}
			} else {
				if (me.data("doc") != void 0) {
					return void 0;
				}
				if (typeof me != "function") {
					r = Core[func](me[0], options);
				} else {
					r = Core[func](options);
				}
				if (ret) {
					return r;
				}
			}
			return void 0;
		};
		return function(options) {
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

	window.url = function(url) {
		if (url.charAt(0) != "/") {
			url = "/" + url;
		}
		return doc["url"] + url;
	};

})(Doc);