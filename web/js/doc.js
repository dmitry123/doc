
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
			var table = $(this).parents("table"),
				id = $(this).parents("tr").attr("data-id");
            me.open(id, table);
		}).on("click", ".file-remove-icon, .template-remove-icon", function() {
            var table = $(this).parents("table"),
                id = $(this).parents("tr").attr("data-id");
            me.remove(id, table);
        }).on("click", ".template-create-icon, .create-template-button", function() {
            var table, id;
            if ($(this).is("button")) {
                table = $(this).parents(".panel:eq(0)").find("table");
            } else {
                table = $(this).parents("table");
            }
            id = $(this).parents("tr").attr("data-id");
            if (!id && !(id = me.active)) {
                throw new Error("Can't resolve file's identification number");
            }
            me.create(id, table);
        }).on("click", ".file-template-manager-download-button", function() {
            if (!me.active) {
                throw new Error("Can't resolve file's identification number");
            } else {
                me.download(me.active);
            }
        });
	},
    open: function(id, table) {
        table && table.table("before");
        Core.loadWidget("FileManager", {
            file: id
        }, function(response) {
            $("#doc-file-template-manager-modal").modal("show").find(".modal-body").empty().append(
                response["component"]
            );
        }).always(function() {
            table && table.table("after");
        });
        this.active = id;
    },
    remove: function(id, table) {
        table && table.table("before");
        Core.sendPost("doc/file/delete", {
            file: id
        }, function() {
            setTimeout(function() {
                table.table("update");
            }, 250);
        }).always(function() {
            table && table.table("after");
        });
    },
    create: function(id, table) {
        table && table.table("before");
        Core.sendPost("doc/template/register", {
            file: id
        }, function(response) {
            setTimeout(function() {
                window.location.href = url("doc/editor/view", {
                    file: response["file"]
                });
            }, 250);
        }).always(function() {
            table && table.table("after");
        });
    },
    download: function(id) {
        var frame = $(".download-frame"),
            ext = frame.parent().find("select[name='ext']");
        if (ext.length > 0) {
            ext = ext.val();
        } else {
            ext = null;
        }
        window.location.href = url("doc/file/download", {
            file: id,
            ext: ext
        });
    },
    active: null
};

var Doc_TemplateEditor_Widget = {
    ready: function() {
		var me = this;
        $(".doc-template-content-editor").menu({
            menu: {
				"editor-insert-element": {
					"label": "Элемент",
					"icon": "fa fa-tags"
				},
                "editor-insert-macro": {
                    "label": "Макрос",
                    "icon": "fa fa-globe"
                },
				"editor-insert-system": {
					"label": "Системный",
					"icon": "fa fa-cog"
				}
            },
            click: function(c) {
				me.click(c);
            }
        });
		$(".builder-apply-macro-button").click(function() {
			var form = $(this).parents(".modal").modal("hide").find("form"),
				macro = form.find("[name='MacroChooseForm[macro]']");
			me.insertMacro(me.last.node, me.last.text, macro.val(),
				macro.children("option[value='"+ macro.val() +"']").text()
			);
		});
		$(document).on("click", ".builder-item-control", function() {
			me.deleteMacro($(this).parent());
		});
		$("#builder-find-macro-modal, #builder-find-element-modal").on("click", "tbody > tr", function() {
			me.insertMacro(me.last.node, me.last.text, $(this).attr("data-id"),
				$(this).children("td:eq(1)").text()
			);
			$(this).parents(".modal").modal("hide");
		});
    },
	click: function(c) {
		if (c == "editor-insert-macro") {
			this.insertSelectedMacro("#builder-find-macro-modal");
		} else if (c == "editor-insert-element") {
			this.insertSelectedMacro("#builder-find-element-modal");
		} else if (c == "editor-insert-system") {

		}
	},
	insertSelectedMacro: function(modal) {
		var selection = window.getSelection(),
			node = $(selection.focusNode.parentNode);
		this.last = {
			node: node,
			text: selection.toString().trim(),
			offset: selection.anchorOffset
		};
		$(modal).modal("show");
	},
	insertMacro: function(node, text, id, name) {
		if (!node instanceof jQuery) {
			node = $(node);
		}
		var path = node.path(".doc-template-content-editor"),
			macro = this.renderItem(name, id, path, text);
			//nt = node.text(),
			//left = nt.substr(0, this.last.offset),
			//right = nt.substr(this.last.offset + text.length);
		//node.html(left + macro[0].outerHTML + right);
		/* # fix for <font> tag */
		if (node.is("font")) {
			var bak = node[0].innerHTML;
			node.html($("<span></span>", {
				html: bak
			}));
			node = node.children("span");
		}
		var t = node[0].outerHTML;
		t = $(t).text();
		text = text.replace(/[\s ]+/g, "&nbsp;");
		t = t.replace(/[\s ]/g, "&nbsp;");
		t = t.replace(text, macro[0].outerHTML);
		node.replaceWith($(node[0].outerHTML).html(t));
		this.inserted.push({
			path: path,
			text: text,
			name: name,
			id: id
		});
	},
	renderItem: function(name, value, path, previous) {
		return $("<b></b>", {
			"class": "builder-item-wrapper",
			"data-value": value,
			"data-previous": previous,
			"data-path": path,
			"text": name
		}).append($("<i></i>", {
			"class": "builder-item-control fa fa-remove"
		}));
	},
	deleteMacro: function(element) {
		for (var i in this.inserted) {
			if (this.inserted[i].path == $(element).attr("data-path")) {
				this.inserted.splice(i, 1);
				break;
			}
		}
		$(element).replaceWith($(element).attr("data-previous"));
	},
	last: {
		node: null,
		text: null
	},
	inserted: []
};

var Doc_TemplateManager_Viewer = {
    ready: function() {
        $(document).on("click", ".template-edit-icon", function() {
            window.location.href = url("doc/editor/view", {
                file: $(this).parents("tr[data-id]").attr("data-id")
            });
        }).on("click", ".template-build-form-icon", function() {
			window.location.href = url("doc/builder/file", {
				file: $(this).parents("tr[data-id]").attr("data-id")
			});
		}).on("click", ".template-build-form-icon", function() {
			window.location.href = url("doc/builder/form", {
				file: $(this).parents("tr[data-id]").attr("data-id")
			});
		})
    }
};

const DOC_MCF_VELOCITY = 300;

var Doc_Macro_Form = {
    ready: function() {
        var me = this;
        $(".doc-macro-create-form").on("change", "[name='MacroForm[columns][]']", function() {
            me.change($(this), $(this).val());
        });
        $("[name='MacroForm[type]'], [name='MacroChooseForm[type]']").change(function() {
            var val = $(this).val(),
                form = $(this).parents("form:eq(0)");
            me.form = form;
            var v = form.find(".form-group[data-field]:visible").slideUp(DOC_MCF_VELOCITY, function() {
                me.show(val);
            });
            if (!v.length) {
                me.show(val);
            }
        });
        $("[name='MacroForm[table]']").change(function() {
            var val = $(this).val(),
                form = $(this).parents("form:eq(0)"),
                it = $(this);
            me.form = form;
			me.hash = val;
            if (val == 0) {
                form.find("select[name='MacroForm[columns][]']").val("");
                form.find(".macro-multiple-container")
                    .slideUp(DOC_MCF_VELOCITY);
                form.find("[name='MacroForm[value]']").parent(".form-group")
                    .slideUp(DOC_MCF_VELOCITY);
                return void 0;
            }
            it.loading({ image: false }).loading("render");
            Core.sendQuery("doc/macro/describe", {
                hash: val
            }, function(response) {
                if (response["empty"]) {
                    return void 0;
                }
				var c = form.find(".field-macroform-columns");
                var e = $(response["component"]);
				c.slideUp(DOC_MCF_VELOCITY, function() {
					c.children(".multiple").remove();
					c.children("input[type='hidden']").remove();
					c.children("label").after(e);
					e.multiple();
					c.slideDown(DOC_MCF_VELOCITY);
				});
                setTimeout(function() {
                    form.find("[name='MacroForm[columns][]'],[name='MacroForm[columns][]']")
                        .parents(".form-group").slideDown(DOC_MCF_VELOCITY);
                }, DOC_MCF_VELOCITY);
            }).always(function() {
                it.loading("reset");
            });
        });
		$(".modal .builder-save-macro-button").click(function() {
			var modal = $(this).parents(".modal");
			modal.find(".doc-macro-create-form").form("send", function() {
				if (modal.attr("id") == "builder-create-macro-modal") {
					$("#builder-macro-panel").find("table").table("update");
				} else {
					$("#builder-element-panel").find("table").table("update");
				}
				modal.modal("hide");
			});
		});
    },
    show: function(type) {
        var form = this.form;
        form.find(".form-group[data-field='" + type + "']").slideDown(DOC_MCF_VELOCITY, function() {
            if (type == "dropdown" || type == "multiple") {
                form.find("[name='MacroForm[table]']").parent(".form-group").slideDown(DOC_MCF_VELOCITY);
            } else {
                form.find("[name='MacroForm[table]']").parent(".form-group").slideUp(DOC_MCF_VELOCITY);
                form.find("select[name='MacroForm[columns][]']").val("");
                form.find("select[name='MacroForm[table]']").val(0);
                form.find(".macro-multiple-container")
                    .slideUp(DOC_MCF_VELOCITY);
            }
        });
    },
    change: function(multiple, columns) {
        var me = this;
        if (!this.hash) {
            throw new Error("Can't resolve active record hash");
        }
        if (!columns) {
            for (var i in this.queue) {
                this.queue[i].abort();
            }
            this.queue = [];
            me.form.find("[name='MacroForm[value]']").empty().append(
                $("<option></option>", {
                    value: 0,
                    text: "Нет"
                })
            );
            return void 0;
        }
        multiple.loading("reset").loading("render");
        var ajax = Core.sendQuery("doc/macro/fetch", {
            type: this.form.find("[name='MacroForm[type]']").val(),
            columns: columns,
            hash: this.hash
        }, function(response) {
            if (!response["component"]) {
                return void 0;
            }
			var m = me.form.find("[name='MacroForm[value]["+ response["type"] +"]']");
            m.replaceWith(response["component"]);
            if (m.attr("multiple")) {
                m.multiple();
            }
            multiple.loading("reset");
        }).fail(function() {
            multiple.loading("reset");
        });
        this.queue.push(ajax);
    },
	slide: function(form, name, show, callback) {
		var g = form.find("[name='"+ name +"']").parent(".form-group");
		if (show) {
			return g.slideDown(DOC_MCF_VELOCITY, callback);
		} else {
			return g.slideUp(DOC_MCF_VELOCITY, callback);
		}
	},
    form: null,
    hash: null,
    queue: []
};

var Doc_MacroChoose_Form = {
	ready: function() {
		$("[name='MacroChooseForm[type]']").change(function() {
			var val = $(this).val(),
				form = $(this).parents("form:eq(0)"),
				it = $(this);
			if (val == 0) {
				return Doc_Macro_Form.slide(form, "MacroChooseForm[macro]", false);
			}
			it.loading({ image: false }).loading("render");
			$.get(url("doc/macro/list"), form.serialize(), function(response) {
				if (!response["status"]) {
					Doc_Macro_Form.slide(form, "MacroChooseForm[macro]", false);
					return Core.createMessage({
						message: response["status"]
					});
				} else {
					form.find("[name='MacroChooseForm[macro]']").replaceWith(
						response["component"]
					);
				}
				Doc_Macro_Form.slide(form, "MacroChooseForm[macro]", true);
			}, "json").always(function() {
				it.loading("reset");
			}).fail(function() {
				Doc_Macro_Form.slide(form, "MacroChooseForm[macro]", false);
			});
		});
	}
};

var Doc_TemplateEditor_Saver = {
	ready: function() {
		var me = this;
		$(".builder-save-button").click(function() {
			me.save();
		});
	},
	save: function() {
		var items = Doc_TemplateEditor_Widget.inserted;
		Core.sendPost("doc/template/save", {
			items: items,
			file: getQuery("file")
		}, function() {
		}).always(function() {
		});
		console.log(items);
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
		dropZoneEnabled: true
	});

	Doc_Navigation_Menu.ready();
	Doc_File_Table.ready();
    Doc_TemplateEditor_Widget.ready();
    Doc_TemplateManager_Viewer.ready();
    Doc_Macro_Form.ready();
	Doc_MacroChoose_Form.ready();
	Doc_TemplateEditor_Saver.ready();

    $("input[type='file'][data-toggle='fileinput']").fileinput({
        uploadUrl: url("doc/file/upload"),
        uploadAsync: true,
        showPreview: false,
        showUpload: false,
        ajaxSettings: {
            success: function() {
            }
        },
        uploadExtraData: {
            form: $("file-upload-modal").find("form")
        }
    });

	$("#builder-create-macro-modal, #builder-create-element-modal").on("show.bs.modal", function() {
		$(this).find(
			".field-macroform-table," +
			".field-macroform-columns," +
			".field-macroform-value"
		).hide();
		$(this).cleanup();
	});

	var updateTables = [
		"#builder-find-macro-modal",
		"#builder-view-macro-modal",
		"#builder-find-element-modal",
		"#builder-view-element-modal"
	];

	$(updateTables.join(",")).on("shown.bs.modal", function() {
		$(this).find("table").table("update");
	});
});