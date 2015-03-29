var Doc = Doc || {};

(function(Doc) {

    "use strict";

    var Loading = function(properties, selector) {
        Doc.Component.call(this, properties, {
            image: "img/ajax-loader.gif",
            size: "60px",
            depth: "2"
        }, selector);
    };

    Doc.extend(Loading, Doc.Component);

    Loading.prototype.render = function() {
        return $("img", {
            css: {
                "position": "absolute",
                "width": this.property("size"),
                "height": this.property("size"),
                "left": "calc(50% - 30px)",
                "top": "calc(50% - 30px)",
                "z-index": this.property("depth")
            },
            src: this.property("image")
        });
    };

    Loading.prototype.activate = function() {

    };

    Doc.createLoading = function(selector, properties) {
        Doc.createObject(new Loading(properties, $(selector)), selector, true);
    };

    $.fn.loading = Doc.createPlugin(
        "createLoading"
    );

})(Doc);