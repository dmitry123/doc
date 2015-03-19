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

	$.fn.fileinput.defaults = $.extend($.fn.fileinput.defaults, {
		msgSizeTooLarge: "Файл \"{name}\" (<b>{size} KB</b>) превышает максимально допустимый размер файла <b>{maxSize} KB</b>. Загрузите другой файл!",
		msgFilesTooMany: "Количество файлов для загрузки <b>({n})</b> превышает максимально допуситмое количество <b>{m}</b>. Загрузите меньшее количество файлов!",
		msgFileNotFound: "Файл \"{name}\" не найден!",
		msgFileSecured: "Security restrictions prevent reading the file \"{name}\".",
		msgFileNotReadable: "Невозможно прочитать файл \"{name}\".",
		msgFilePreviewAborted: "Запрещен предпросмотр файла \"{name}\".",
		msgFilePreviewError: "Произошла ошибка при чтении файла \"{name}\".",
		msgInvalidFileType: "Неверный тип файла \"{name}\". Допустимы только \"{types}\".",
		msgInvalidFileExtension: "Неверное расширение для файла \"{name}\". Допустимы только \"{extensions}\".",
		msgValidationError: "<span class=\"text-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i>Ошибка при загрузке файла</span>",
		browseLabel: "Выбрать &hellip;",
		browseIcon: "<i class=\"glyphicon glyphicon-folder-open\"></i> &nbsp;",
		browseClass: "btn btn-primary",
		removeLabel: "Удалить",
		removeTitle: "Удалить выбранные элементы",
		removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
		removeClass: "btn btn-danger",
		cancelLabel: "Отмена",
		cancelTitle: "Отменить загрузку файлов",
		cancelIcon: "<i class=\"glyphicon glyphicon-ban-circle\"></i> ",
		cancelClass: "btn btn-default",
		uploadLabel: "Загрузить",
		uploadTitle: "Загрузить выбранные файлы",
		uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
		uploadClass: "btn btn-success",
		dropZoneTitle: "Перетащите файлы сюда &hellip;"
	});

	$("#documents-file").fileinput({
		uploadUrl: url(""),
		uploadAsync: true,
		maxFileCount: 10,
		uploadExtraData: {
			userId: doc["user"]["id"]
		}
	});

    ConfirmDeleteModal.ready();
});