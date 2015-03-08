var Doc = Doc || {};

(function(Doc) {

	"use strict";

	/**
	 * Extend child class with parent
	 * @param child {function} - Child class
	 * @param parent {function} - Parent class
	 * @returns {function} - Child class
	 */
	Doc.extend = function(child, parent) {
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
			if (!selector.data("laboratory")) {
				selector.data("laboratory", this);
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
		this.selector().remove();
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

	Doc.Component = Component;

	/**
	 * Sub-Component class, use it to declare sub component, that instance
	 * won't be rendered automatically, you shall manually invoke render method
	 * @param component {Component} - Parent component
	 * @param [selector] {jQuery} - jQuery's selector or null
	 * @constructor
	 */
	var Sub = function(component, selector) {
		this.component = function() {
			return component;
		};
		Doc.Component.call(this, {}, {}, selector || true);
	};

	Doc.extend(Sub, Component);

	/**
	 * That method will fetch properties values from
	 * parent's component
	 * @param key {String} - Property name
	 * @param value {*} - Property value
	 */
	Sub.prototype.property = function(key, value) {
		return this.component().property.apply(this.component(), arguments);
	};

	/**
	 * Create new component's instance and render to DOM
	 * @param component {Component|Object} - Component's instance
	 * @param selector {HTMLElement|string} - Parent's selector
	 * @param [update] {Boolean} - Update component or not (default yes)
	 * @static
	 */
	Doc.createObject = function(component, selector, update) {
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
	 * Create plugin for component where
	 * @param func {String} - Name of create function, for example 'createMessage'
	 * @static
	 */
	Doc.createPlugin = function(func) {
		return function(options) {
			if (typeof options == "string") {
				var c = $(this).data("doc");
				if (!c) {
					throw new Error("Component hasn't been initialized, create it first");
				}
				c[options].apply(c, arguments.splice(0, 1));
			} else {
				if (typeof this != "function") {
					Doc[func](this[0], options);
				} else {
					Doc[func](options);
				}
			}
			return this;
		};
	};

	/**
	 * Is string ends with some suffix
	 * @param suffix {string} - String suffix
	 * @returns {boolean} - True if string has suffix
	 */
	String.prototype.endsWith = function(suffix) {
		return this.indexOf(suffix, this.length - suffix.length) !== -1;
	};

	/**
	 * Is string starts with some prefix
	 * @param prefix {string} - String prefix
	 * @returns {boolean} - True if string has prefix
	 */
	String.prototype.startsWidth = function(prefix) {
		return this.indexOf(prefix, 0) !== -1;
	};

})(Doc);

$(document).ready(function() {
	$("input[data-regexp][type='text']").each(function(i, item) {
		var regexp = new RegExp($(item).data("regexp"));
		$(item).keydown(function(e) {
			console.log($(item).val());
			console.log(regexp.test($(item).val()));
		});
	});
});

/*
 var isStrValid = function(str) {
 return ((str.match(/[^\d^.]/) === null)
 && (str.replace(/\d+\.?\d?\d?/, "") === ""));
 };

 var node = dojo.byId("txt");
 dojo.connect(node, "onkeyup", function() {
 if (!isStrValid(node.value)) {
 node.value = node.value.substring(0, node.value.length-1);
 }
 });
 * */