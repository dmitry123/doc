var Core = Core || {};

(function(Core) {

    "use strict";

	var Loading = Core.createComponent(function(properties, selector) {
		Core.Component.call(this, properties, {
			image: url("img/ajax-loader-3.gif"),
			depth: 1000,
			width: 75,
			height: 75,
			velocity: "fast",
			color: "lightgray",
			message: false,
			font: {
				"font-size": 20,
				"color": "black"
			}
		}, selector);
	});

    Loading.prototype.render = function() {
		var imageWidth = this.property("width"),
			imageHeight = this.property("height"),
			height = this.selector().outerHeight(false),
			width = this.selector().outerWidth(false);
		if (this.hasOwnProperty("image")) {
			return void 0;
		}
		var index, image;
		if (!(index = parseInt(this.selector().css("z-index")))) {
			index = this.property("depth");
		} else {
			index += 1;
		}
		this.image = true;
        if (this.property("image")) {
            image = $("<img>", {
                css: {
                    "position": "absolute",
                    "height": imageHeight,
                    "width": imageWidth,
                    "left": "calc(50% - " + (imageWidth / 2) + "px)",
                    "margin-top": height / 2 - imageHeight / 2,
                    "z-index": index
                },
                src: this.property("image")
            });
        } else {
            image = $("<img>", {
                css: {
                    "position": "absolute",
                    "visibility": "hidden"
                }
            });
        }
		if (this.property("message") != false) {
			this.image = $("<div>", {
				css: {
					"float": "left"
				}
			}).append($("<span>", {
				text: this.property("message"),
				style: image.attr("style"),
				css: $.extend(this.property("font"), {
					"width": "100%",
					"left": "0px",
					"text-align": "center",
					"margin-top": height / 2 - 30
				})
			})).append(image.css({
				"margin-top": height / 2 - imageHeight / 2 + 30
			}));
		} else {
			this.image = image;
		}
		this.selector().before(this.back = $("<div>", {
			css: {
				"width": width,
				"height": height,
				"position": "absolute",
				"background-color": this.property("color"),
				"opacity": "0.5",
				"z-index": "100"
			}
		}).addClass(this.selector().attr("class")).fadeIn(this.property("velocity"))).before(
			this.image.fadeIn(this.property("velocity"))
		);
    };

	Loading.prototype.backdrop = function() {
		var imageWidth = this.property("width"),
			imageHeight = this.property("height");
		if (this.hasOwnProperty("image")) {
			this.image.remove();
		}
		if (this.hasOwnProperty("back")) {
			this.back.remove();
		}
		var image = $("<img>", {
			css: {
				"position": "absolute",
				"height": imageHeight,
				"width": imageWidth,
				"left": "calc(50% - " + (imageWidth / 2) + "px)",
				"top": "calc(50% - " + (imageHeight / 2) + "px)",
				"z-index": "2001"
			},
			src: this.property("image")
		});
		if (this.property("message") != false) {
			this.image = $("<div>", {
				css: {
					"float": "left"
				}
			}).append($("<span>", {
				text: this.property("message"),
				style: image.attr("style"),
				css: $.extend(this.property("font"), {
					"width": "100%",
					"left": "0px",
					"text-align": "center",
					"top": "150px",
					"margin-top": "0px",
					"font-size": "50px"
				})
			})).append(image.css({
				"top": "200px",
				"margin-top": "0px",
				"width": "100px",
				"height": "100px"
			}));
		} else {
			this.image = image;
		}
		this.selector().append(this.back = $("<div>", {
			css: {
				"position": "absolute",
				"width": "100%",
				"height": "100%",
				"left": "0px",
				"top": "0px",
				"background-color": this.property("color"),
				"opacity": "0.5",
				"z-index": "2000"
			}
		}).addClass(this.selector().attr("class")).fadeIn(this.property("velocity"))).before(
			this.image.fadeIn(this.property("velocity"))
		);
	};

	Loading.prototype.update = function() {
		this.render();
	};

	Loading.prototype.destroy = function(callback) {
		this.reset(function() {
			Core.Component.prototype.destroy.call(this);
			callback && callback();
		});
	};

    Loading.prototype.reset = function(after) {
		var me = this;
        this.image && this.image.fadeOut(this.property("velocity"), function() {
			$(this).remove();
			delete me.image;
			after && after.call(me);
		});
        this.back && this.back.fadeOut(this.property("velocity"), function() {
			$(this).remove();
			delete me.back;
		});
    };

	$.fn.loading = Core.createPlugin("loading", function(selector, properties) {
		if (!$(selector).data("core-loading") || !$(selector).data("core-loading").image) {
			return Core.createObject(new Loading(properties, $(selector)), selector, true);
		} else {
			return void 0;
		}
	});

})(Core);