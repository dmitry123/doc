
var Doc_Navigation_Menu = {
	ready: function() {
        var me = this;
		$("#menu-doc-upload").click(function() {
			$("#doc-file-upload-wrapper").slideToggle("normal");
		});
		$("#document-file-upload").fileinput({
			uploadUrl: url("doc/file/upload"),
            uploadAsync: true,
            ajaxSettings: {
                success: me.afterUpload
            },
			uploadExtraData: {
				form: $("file-upload-modal").find("form")
			}
		}).on("filebatchselected", function() {
			//$(this).fileinput("upload");
		});
		$("#file-upload-modal").on("show.bs.modal", function() {
			$("#document-file-upload").fileinput("clearFileInput");
		});
	},
    afterUpload: function(json) {
        if (!json["status"]) {
			var errors = json["errors"];
			for (var i in errors) {
				Core.createMessage({ message: i + ": " + errors[i], delay: 7000 });
			}
        } else {
			//$("#file-upload-modal").modal("hide");
		}
    }
};

var Doc_File_Table = {
	ready: function() {
        var me = this,
            modal = $("#doc-file-template-manager-modal");
		$("body").on("click", ".file-open-icon", function() {
			var table = $(this).parents("table").table("before"),
				id = $(this).parents("tr").attr("data-id");
            Core.loadWidget("File_TemplateManager_Viewer", {
                file: id
            }, function(response) {
                modal.modal("show").find(".modal-body").empty().append(
                    response["component"]
                );
            }).always(function() {
                table.table("after");
            });
            me.active = id;
		}).on("click", ".file-remove-icon", function() {
            var table = $(this).parents("table").table("before");
            Core.sendPost("doc/file/delete", {
                file: $(this).parents("tr[data-id]").attr("data-id")
            }, function() {

            }).always(function() {
                table.table("after");
            });
        }).on("click", ".template-create-icon, .create-template-button", function() {
            var table, id;
            if ($(this).is("button")) {
                table = $(this).parents(".panel:eq(0)").find("table").table("before");
            } else {
                table = $(this).parents("table").table("before");
            }
            id = $(this).parents("tr").attr("data-id");
            if (!id && !(id = me.active)) {
                throw new Error("Can't resolve file's identification number");
            }
            Core.sendPost("doc/template/register", {
                file: id
            }, function(response) {
                setTimeout(function() {
                    window.location.href = url("doc/editor/view", {
                        file: response["file"]
                    });
                }, 250);
            }).always(function() {
                table.table("after");
            });
        });
	},
    active: null
};

var Doc_TemplateContentEditor_Widget = {
    ready: function() {
        $(".doc-template-content-editor").menu({
            menu: {
                "editor-insert-element": {
                    "label": "Вставить элемент",
                    "icon": "fa fa-tags"
                },
                "editor-insert-macros": {
                    "label": "Вставить макрос",
                    "icon": "fa fa-bookmark"
                },
                "editor-insert-reference": {
                    "label": "Вставить ссылку",
                    "icon": "fa fa-link"
                }
            },
            click: function(c) {
                console.log(c);
            }
        });
    }
};

var Doc_TemplateManager_Viewer = {
    ready: function() {
        $(document).on("click", ".template-edit-icon", function() {
            window.location.href = url("doc/editor/view", {
                file: $(this).parents("tr[data-id]").attr("data-id")
            });
        });
    }
};

$(document).ready(function() {

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
		removeLabel: "Удалить",
		removeTitle: "Удалить выбранные элементы",
		removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
		removeClass: "btn btn-danger",
		cancelLabel: "Отмена",
		cancelTitle: "Отменить загрузку файлов",
		cancelIcon: "<i class=\"glyphicon glyphicon-ban-circle\"></i> ",
		uploadLabel: "Загрузить",
		uploadTitle: "Загрузить выбранные файлы",
		uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
		dropZoneTitle: "Перетащите файлы сюда &hellip;",
		uploadAsync: true,
		showUpload: true,
		showRemove: false,
		//showPreview: false,
		dropZoneEnabled: true
	});

	Doc_Navigation_Menu.ready();
	Doc_File_Table.ready();
    Doc_TemplateContentEditor_Widget.ready();
    Doc_TemplateManager_Viewer.ready();
});