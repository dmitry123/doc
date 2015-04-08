var Doc = Doc || {};

(function(Doc) {

    "use strict";

    var Loading = function(properties, selector) {
        Doc.Component.call(this, properties, {
            image: "../img/ajax-loader.gif",
            size: "80",
            depth: "200",
			velocity: "fast"
        }, selector);
    };

    Doc.extend(Loading, Doc.Component);

    Loading.prototype.render = function() {
		var half = this.property("size") / 2;
		this.image = $("<img>", {
			css: {
				"position": "absolute",
				"width": this.property("size"),
				"height": this.property("size"),
				"left": "calc(50% - " + half + "px)",
				"top": "calc(50% - " + half + "px)",
				"z-index": this.property("depth")
			},
			src: this.property("image")
		});
		this.selector().before(this.back = $("<div>", {
			css: {
				"width": this.selector().width(),
				"height": this.selector().height(),
				"position": "absolute",
				"background-color": "whitesmoke",
				"opacity": "0.5",
				"z-index": "100"
			}
		}).addClass(this.selector().attr("class")).fadeIn(this.property("velocity"))).before(
			this.image.fadeIn(this.property("velocity"))
		);
		return this.selector().animate({
			"opacity": 0.4
		}, this.property("velocity"));
    };

    Loading.prototype.reset = function() {
		if (this.image) {
			this.image.fadeOut(this.property("velocity"));
		}
		if (this.back) {
			this.back.fadeOut(this.property("velocity"));
		}
		this.selector().animate({
			"opacity": 1
		}, this.property("velocity"));
    };

    Doc.createLoading = function(selector, properties) {
		if (!$(selector).data("doc") || !$(selector).data("doc").image) {
			return Doc.createObject(new Loading(properties, $(selector)), selector, true);
		} else {
			return void 0;
		}
    };

    $.fn.loading = Doc.createPlugin("createLoading");

})(Doc);