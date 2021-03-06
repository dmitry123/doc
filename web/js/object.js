var Core = Core || {};

(function(Core) {

	"use strict";

	/**
	 * Create configuration for constant variable
	 * for {@see Component#defineProperty} method
	 *
	 * @param {*} [value] any value, that should be default, elsewhere
	 * 	null is used
	 *
	 * @returns {{
	 * 	enumerable: boolean,
	 * 	writable: boolean,
	 * 	configurable: boolean,
	 * 	value: (*|null)
	 * }}
	 * @private
	 */
	var _let = function(value) {
		return {
			enumerable: false,
			writable: false,
			configurable: false,
			value: value || null
		};
	};

	/**
	 * Create configuration for normal variable
	 * for {@see Component#defineProperty} method
	 *
	 * @param {*} [value] any value, that should be default, elsewhere
	 * 	null is used
	 *
	 * @returns {{
	 * 	enumerable: boolean,
	 * 	writable: boolean,
	 * 	configurable: boolean,
	 * 	value: (*|null)
	 * }}
	 * @private
	 */
	var _var = function(value) {
		return {
			enumerable: false,
			writable: true,
			configurable: false,
			value: value || null
		};
	};

    /**
     * Basic protocol of object class with
     * interface methods that should be implemented
     *
     * @type {{
     *  prop: Function
     * }}
     */
    var ObjectProtocol = {
        prop: function(key, value) {}
    };

	/**
	 * Basic protocol of component class with
	 * interface methods that should be implemented
	 *
	 * @type {{
	 * 	render: Function,
	 * 	update: Function,
	 * 	activate: Function,
	 * 	before: Function,
	 * 	after: Function,
	 * 	element: Function,
	 * 	prop: Function
	 * }}
	 */
	var ComponentProtocol = {
		render: function() {},
		update: function() {},
		activate: function() {},
		before: function() {},
		after: function() {},
		element: function(value) {}
	};

    /**
     * Basic protocol of plugin class with
     * interface methods that should be implemented
     *
     * @type {{
     *  name: Function
     * }}
     */
    var PluginProtocol = {
        name: function() {}
    };

    /**
     * @param {{}} [fields] object with class's
     * 	fields and it's default values
     *
     * @param {{}} [props] object with component's
     * 	properties, that sets to object's model
     */
    var Basic = Core.Object = function(fields, props) {
        Object.defineProperties(this, $.extend({
            '_model': _var(props)
        }, fields || {}));
    };

    /**
     * Extend basic class object to produce new
     * sub component class element
     *
     * @param {{}} [fields] object with class's
     * 	fields and it's default values
     *
     * @param {Function} [extend] object's extend
     *  method, which overrides current
     *
     * @param {{}} [proto] object's default prototype
     * 	that will extends current
     *
     * @static
     */
    Basic.extend = function(fields, extend, proto) {
        var me = this;
        var f = function(props) {
            me.apply(this, [ fields, props || {} ]);
        };
        f.prototype = Object.create($.extend(
            this.prototype, proto || {}
        ));
        f.prototype.super = this;
        f.extend = extend ||Basic.extend;
        return f;
    };

    /**
     * Use that method to set class's methods
     * that it must implement from protocol
     *
     * @param {{}} protocol object with methods have
     * 	to be implemented, it can return extra information
     * 	about error as string
     *
     * @static
     */
    Basic.implement = function(protocol) {
        var p = this.prototype, i, m;
        if (Array.isArray(protocol)) {
            for (i in protocol) {
                Basic.implement(protocol[i]);
            }
            return void 0;
        }
        for (i in protocol) {
            if (i in p && p.can(i)) {
                continue;
            }
            if (typeof protocol[i] == "function") {
                m = protocol[i].call() || i;
            } else {
                m = i;
            }
            throw new Error("Class must implements method ["+ m +"]");
        }
    };

    /**
     * Use that method to manipulate with component's model,
     * if it passed only one argument, then it works as getter
     * else it works as setter
     *
     * @param {String} key name of property that
     * 	associated with value you want set or get
     *
     * @param {*} [value] any value associated
     * 	with property that bind to current component
     */
    Basic.prototype.prop = function(key, value) {
        if (!this._model) {
            this._model = {};
        }
        if (arguments.length > 1) {
            return this._model[key] = value;
        } else {
            return this._model[key];
        }
    };

    /**
     * Backward compatibility {@see Core.Object#prop}
     *
     * @param {String} key name of property that
     * 	associated with value you want set or get
     *
     * @param {*} [value] any value associated
     * 	with property that bind to current component
     *
     * @see Core.Object#prop
     */
    Basic.prototype.property = function(key, value) {
        this.prototype.prop.apply(this, arguments);
    };

	/**
	 * @param {{}} [fields] object with class's
	 * 	fields and it's default values
	 *
	 * @param {{}} [props] object with component's
	 * 	properties, that sets to object's model
	 *
	 * @param {jQuery|HTMLElement|String} [element] element
	 * 	associated with component, not required
	 */
    var Component = Core.Component = Basic.extend({
        "_element": _var(null)
    }, function(element, fields, extend, proto) {
        var f = function(props) {
            this.super.apply(this, [ element, fields, props || {} ]);
        };
        f.prototype = Object.create($.extend(
            this.prototype, proto || {}
        ));
        f.prototype.super = this;
        f.extend = extend ||Basic.extend;
        return f;
    }, ComponentProtocol);

	/**
	 * Override that method to return just rendered jQuery
	 * element which will appended to parent node
	 *
	 * @return jQuery element for HTML node tree
	 */
	Component.prototype.render = function() {};

	/**
	 * Override that method to update your jQuery
	 * component, it should invokes {@see Core.Object#before}
	 * and {@see Core.Object#after} methods to provider
	 * elements animation or stuff for triggers
	 *
	 * @see Core.Object#after
	 * @see Core.Object#before
	 */
	Component.prototype.update = function() {};

	/**
	 * Override that method to active your just
	 * rendered jQuery component, that means that you
	 * have you bind events listeners to object and
	 * it's sub components
	 *
	 * @see Core.Object#render
	 */
	Component.prototype.activate = function() {};

	/**
	 * Override that method to provider some actions
	 * before element's update or fetch, like trigger
	 * events or something else
	 *
	 * @see Core.Object#update
	 */
	Component.prototype.before = function() {};

	/**
	 * Override that method to provider some actions
	 * after element's update or fetch, like trigger
	 * events or something else
	 *
	 * @see Core.Object#update
	 */
	Component.prototype.after = function() {};

	/**
	 * That method returns current jQuery element
	 * that appended to component's instance, previous method
	 * name was {@see Core.Object#selector}, which still
	 * here for backward compatibility
	 *
	 * @param {jQuery} [element] component's view jQuery
	 * 	element, that associated with interface element
	 *
	 * @returns {jQuery} - current or new component's
	 * 	view element
	 *
	 * @see Core.Object#selector
	 */
	Component.prototype.element = function(element) {
		if (arguments.length > 0 && element !== void 0) {
			if (!(element instanceof jQuery)) {
				throw new Error("Selector must be an instance of jQuery object");
			} else {
				if (!element.data(this.getDataAttribute())) {
					element.data(this.getDataAttribute(), this);
				}
				return this._element = element;
			}
		}
		return this._element;
	};

	/**
	 * Backward compatibility {@see Core.Object#element}
	 *
	 * @param {jQuery} [element] component's view jQuery
	 * 	element, that associated with interface element
	 *
	 * @returns {jQuery} current or new component's
	 * 	view element
	 *
	 * @see Core.Object#element
	 */
	Component.prototype.selector = function(element) {
		return this.prototype.element.apply(this, arguments);
	};

    /**
     * Plugin class, which extends basic component
     * to register it as jQuery plugin
     *
     * @param {String} name - Name of jQuery plugin
     * @constructor
     */
    var Plugin = function(name) {
        Object.defineProperties(this, {
            "_name": _let(name)
        });
    };

    /**
     * That method returns name of data attribute for
     * current component
     * @returns {string} - Attribute name
     */
    Plugin.prototype.name = function() {
        if (!this._name) {
            throw new Error("Object hasn't been registered as jQuery plugin");
        } else {
            return this._name;
        }
    };

	Component.assign = Component.assign || function(target, firstSource) {
		if (target === undefined || target === null) {
			throw new Error('Cannot convert first argument to object');
		} else {
			var to = Component(target),
				src;
		}
		for (var i = 1; i < arguments.length; i++) {
			if ((src = arguments[i]) === undefined || src === null) {
				continue;
			}
			var keys = Component.keys(Component(src)),
				key;
			for (var index = 0, len = keys.length; index < len; index++) {
				var desc = Component.getOwnPropertyDescriptor(src, key = keys[index]);
				if (desc !== undefined && desc.enumerable) {
					to[key] = src[key];
				}
			}
		}
		return to;
	};

	Component.create = Component.create || function() {
		var Temp = function() {};
		return function (prototype) {
			if (arguments.length > 1) {
				throw Error('Second argument not supported');
			}
			if (typeof prototype != 'object') {
				throw Error('Argument must be an object');
			}
			Temp.prototype = prototype;
			var result = new Temp();
			Temp.prototype = null;
			return result;
		};
	};

	/**
	 * Create and register core component as jQuery plugin
	 *
	 * @param plugin {String} name of jQuery
	 * 	plugin {@see Component#getDataAttribute}
	 *
	 * @param func {Function} Function that registers
	 * 	component, it have to assume jQuery element
	 * 	with configuration parameters
	 *
	 * @static
	 */
	var createPlugin = function(plugin, func) {
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

	var PluginFactory = Core.PluginFactory = {
		create: function(plugin, func) {
			if (this.plugins[plugin]) {
				this.plugins[plugin].push(
					createPlugin(plugin, func)
				);
			} else {
				this.plugins[plugin] = [
					createPlugin(plugin, func)
				];
			}
		},
		plugins: {}
	};

	Object.defineProperty(Component.prototype, "can", {
		enumerable: false, value: function(method) {
			return typeof this[method] === "function";
		}
	});

})(Core);