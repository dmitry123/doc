var ConfirmDeleteModal = {
    confirm: function(e, message) {
        if (!this.lock) {
            this.item = $(e.target);
        } else {
            return void 0;
        }
        var m = $("#confirm-delete-modal").modal();
        if (message != void 0) {
            m.find(".modal-body > div > div").text(message);
        }
        e.stopImmediatePropagation();
        return false;
    },
    ready: function() {
        var me = this;
        $(document).on("click", ".confirm-delete", function(e) {
            me.confirm(e);
        }).find(".confirm-delete").click(function(e) {
            me.confirm(e);
        });
        $("#confirm-delete-modal").find("button[type='submit']").click(function() {
            me.lock = true;
            if (me.item != null) {
                me.item.trigger("click");
            }
            setTimeout(function() {
                me.lock = false;
            }, 250);
        });
    },
    item: null,
    lock: false
};

$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
    ConfirmDeleteModal.ready();
    window["confirmDelete"] = function(message) {
        ConfirmDeleteModal.confirm(window.event, message);
    };
    $(".modal").on("show.bs.modal", function() {
        if ($("body").height() > $(window).height()) {
            $("#navigation").find("> .container-fluid").css({
                "margin-right": "17px"
            });
        }
    }).on("hidden.bs.modal", function() {
        if ($("body").height() > $(window).height()) {
            $("#navigation").find("> .container-fluid").css({
                "margin-right": "0"
            });
        }
    });
	$.fn.modal.Constructor.DEFAULTS.keyboard = false
});