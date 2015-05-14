var Core = Core || Core;

(function(Core) {

    "use strict";

    Core.CONTEXT_DEFAULTS = {
        menu: {
        },
        click: null
    };

    /**
     * Construct context menu with properties
     * and selector
     *
     * Properties: {
     *  + [menu] {{}} - Object with menu elements where key is class and body is:
     *  + + label {String} - Displayable label or null
     *  + + [icon] {String} - Glyphicon or Fa icon before label
     *  + [click] - Event, which raise after item click
     * }
     *
     * You can add custom HTML component to menu element,
     * simply
     */
    var Context = Core.createComponent(function(properties, selector) {
        Core.Component.call(this, properties, Core.CONTEXT_DEFAULTS, selector);
    });

    Context.prototype.render = function() {
        var me = this;
        var ul = $("<ul>", {
            "class": "dropdown-menu",
            "role": "menu"
        });
        var menu = this.property("menu");
        for (var i in menu) {
            var m = menu[i],
                label = m["label"],
                li = $("<li>", {
                    "class": i
                });
            if (m["icon"]) {
                label = "<i class=\""+ m["icon"] +"\"></i>&nbsp; " + label;
            }
            li.append($("<a>", {
                "href": "javascript:void(0)",
                "html": label
            })).data("click", m["click"]);
            ul.append(li.on("click", function() {
                if ($(this).data("click")) {
                    $(this).data("click").call(this, $(this).attr("class"));
                }
                me.property("click") && me.property("click").call(this, $(this).attr("class"));
            }));
        }
        this._ul = ul;
    };

    Context.prototype.activate = function() {
        var me = this;
        if (!this._ul) {
            return void 0;
        }
        var getMenuPosition = function(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(me._ul)[direction](),
                position = mouse + scroll;
            if (mouse + menu > win && menu < mouse) {
                position -= menu;
            }
            return position;
        };
        this.selector().on("contextmenu", function(e) {
            if (e.ctrlKey) {
                return void 0;
            }
            me._ul.css({
                "left": getMenuPosition(e.clientX, "width", "scrollLeft"),
                "top": getMenuPosition(e.clientY, "height", "scrollTop")
            }).show();
            return false;
        });
        $(document).click(function() {
            me._ul.hide();
        });
        $("body").append(me._ul.css({
            "position": "absolute"
        }).hide());
    };

    $.fn.menu = Core.createPlugin("menu", function(selector, properties) {
        return Core.createObject(new Context(properties, $(selector)), selector, true);
    });

})(Core);