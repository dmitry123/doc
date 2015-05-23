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
    "id" => "builder-create-macro-modal"
]);
print \app\widgets\Modal::widget([
    "title" => "Поиск макроса",
    "id" => "builder-find-macro-modal"
]);
print \app\widgets\Modal::widget([
    "title" => "Просмотр списка макросов",
    "body" => \app\widgets\Grid::widget([
        "provider" => new \app\modules\doc\grids\EditorMacroGridProvider()
    ]),
    "id" => "builder-view-macro-modal"
]) ?>
<?= \app\modules\doc\widgets\EditorFileMenu::widget() ?>
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
</div>