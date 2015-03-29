var ConfirmDeleteModal = {
    ready: function() {
        var me = this;
        $(document).on("click", ".confirm-delete", function(e) {
            if (me.lock) {
                return void 0;
            }
            me.item = $(e.target);
            $("#confirm-delete-modal").modal();
            e.stopImmediatePropagation();
            return false;
        });
        $("#confirm-delete-button").click(function() {
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