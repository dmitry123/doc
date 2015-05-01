var ConfirmDeleteModal = {
    confirm: function(e) {
        if (!this.lock) {
            this.item = $(e.target);
        } else {
            return void 0;
        }
        $("#confirm-delete-modal").modal();
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
});