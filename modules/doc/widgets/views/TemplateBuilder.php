<?php
/**
 * @var $this \yii\web\View
 * @var $file mixed
 */
print \app\widgets\Modal::widget([
    "title" => "Создание нового элемента",
    "id" => "builder-create-element-modal"
]);
print \app\widgets\Modal::widget([
    "title" => "Поиск элемента",
    "id" => "builder-find-element-modal"
]);
print \app\widgets\Modal::widget([
    "title" => "Просмотр списка элементов",
    "id" => "builder-view-element-modal"
]);
print \app\widgets\Modal::widget([
    "title" => "Создание нового макроса",
    "body" => \app\modules\doc\widgets\MacroMaker::widget([]),
	"buttons" => [
		"builder-save-macro-button" => [
			"text" => "Сохранить",
			"class" => "btn btn-primary",
			"type" => "button",
			"onclick" => "",
		]
	],
    "id" => "builder-create-macros-modal"
]);
print \app\widgets\Modal::widget([
    "title" => "Поиск макроса",
    "id" => "builder-find-macros-modal"
]);
print \app\widgets\Modal::widget([
    "title" => "Просмотр списка макросов",
    "body" => \app\widgets\Grid::widget([
        "provider" => new \app\modules\doc\grids\EditorMacroGridProvider()
    ]),
    "id" => "builder-view-macros-modal"
]) ?>
<?= \app\modules\doc\widgets\EditorFileMenu::widget([
	"items" => [
		"builder-open-button" => [
			"label" => "Открыть",
			"icon" => "fa fa-folder-open-o"
		],
		"builder-save-button" => [
			"label" => "Сохранить",
			"icon" => "fa fa-save"
		],
		"builder-preview-button" => [
			"label" => "Предпросмотр",
			"icon" => "fa fa-file-text-o"
		],
		"builder-print-button" => [
			"label" => "Печать",
			"icon" => "fa fa-print"
		],
		"builder-element-button" => [
			"label" => "Элементы",
			"icon" => "fa fa-tags",
			"items" => [
				"builder-element-create-button" => [
					"label" => "Создать",
					"icon" => "fa fa-plus",
                    "onclick" => "$('#builder-create-element-modal').modal('show')",
				],
				"builder-element-find-button" => [
					"label" => "Найти",
					"icon" => "fa fa-search",
                    "onclick" => "$('#builder-find-element-modal').modal('show')",
				],
				"builder-element-edit-button" => [
					"label" => "Просмотреть",
					"icon" => "fa fa-pencil",
                    "onclick" => "$('#builder-view-element-modal').modal('show')",
				],
			]
		],
		"builder-macros-button" => [
			"label" => "Макросы",
			"icon" => "fa fa-th",
			"items" => [
				"builder-macros-create-button" => [
					"label" => "Создать",
					"icon" => "fa fa-plus",
                    "onclick" => "$('#builder-create-macros-modal').modal('show')",
				],
				"builder-macros-find-button" => [
					"label" => "Найти",
					"icon" => "fa fa-search",
                    "onclick" => "$('#builder-edit-macros-modal').modal('show')",
				],
				"builder-macros-edit-button" => [
					"label" => "Просмотреть",
					"icon" => "fa fa-pencil",
                    "onclick" => "$('#builder-view-macros-modal').modal('show')",
				],
			]
		]
	]
]) ?>
<div class="col-xs-12 editor-template-builder-wrapper">
<div class="col-xs-offset-2 col-xs-8">
	<?= \app\widgets\Panel::widget([
		"title" => "Содержимое файла",
		"id" => "doc-editor-content-panel",
		"body" => \app\modules\doc\widgets\TemplateEditor::create([
			"file" => $file->{"id"}
		]),
		"bodyClass" => "panel-body clear",
		"upgradeable" => false
	]) ?>
</div>
<!--<div class="col-xs-5">-->
<!--	--><?//= \app\widgets\Panel::widget([
//		"title" => "Информация",
//		"body" => \app\modules\doc\widgets\Editor_AboutTemplate_Editor::create([
//			"file" => $file->{"id"}
//		])
//	]) ?>
<!--	<hr>-->
<!--	--><?//= \app\widgets\Panel::widget([
//		"title" => "Элементы шаблонов",
//		"body" => \app\modules\doc\widgets\Editor_TemplateElement_List::create([
//			"manager" => \app\modules\doc\core\ElementManager::getManager()
//		]),
//		"controls" => [
//			"panel-create-button" => [
//				"label" => "Создать",
//				"icon" => "glyphicon glyphicon-plus",
//				"class" => "btn btn-primary btn-sm"
//			],
//			"panel-update-button" => [
//				"label" => "Обновить",
//				"icon" => "glyphicon glyphicon-refresh",
//				"onclick" => "$(this).panel('update')",
//				"class" => "btn btn-default btn-sm",
//			],
//		]
//	]) ?>
<!--	<hr>-->
<!--	<div class="btn-group">-->
<!--		<button class="btn btn-success btn-lg">-->
<!--			<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить-->
<!--		</button>-->
<!--		<button class="btn btn-default btn-lg">-->
<!--			<i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Предпросмотр-->
<!--		</button>-->
<!--		<button class="btn btn-default btn-lg">-->
<!--			<i class="fa fa-print"></i>&nbsp;&nbsp;Печать-->
<!--		</button>-->
<!--	</div>-->
<!--</div>-->
</div>