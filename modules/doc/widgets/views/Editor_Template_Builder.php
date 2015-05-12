<?php
/**
 * @var $this \yii\web\View
 * @var $file mixed
 */
?>
<?= \app\modules\doc\widgets\Editor_ControlMenu_Nav::widget([
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
		]
	]
]) ?>
<div class="col-xs-12 editor-template-builder-wrapper">
<div class="col-xs-7 clear">
	<?= \app\widgets\Panel::widget([
		"title" => "Содержимое файла",
		"id" => "doc-editor-content-panel",
		"body" => \app\modules\doc\widgets\Editor_Content_Editor::create([
			"file" => $file->{"id"}
		]),
		"bodyClass" => "panel-body clear",
		"upgradeable" => false
	]) ?>
</div>
<div class="col-xs-5">
	<?= \app\widgets\Panel::widget([
		"title" => "Информация",
		"body" => \app\modules\doc\widgets\Editor_AboutTemplate_Editor::create([
			"file" => $file->{"id"}
		])
	]) ?>
	<hr>
	<?= \app\widgets\Panel::widget([
		"title" => "Элементы шаблонов",
		"body" => \app\modules\doc\widgets\Editor_TemplateElement_List::create([
			"manager" => \app\modules\doc\core\ElementManager::getManager()
		]),
		"controls" => [
			"panel-create-button" => [
				"label" => "Создать",
				"icon" => "glyphicon glyphicon-plus",
				"class" => "btn btn-primary btn-sm"
			],
			"panel-update-button" => [
				"label" => "Обновить",
				"icon" => "glyphicon glyphicon-refresh",
				"onclick" => "$(this).panel('update')",
				"class" => "btn btn-default btn-sm",
			],
		]
	]) ?>
	<hr>
	<div class="btn-group">
		<button class="btn btn-success btn-lg">
			<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить
		</button>
		<button class="btn btn-default btn-lg">
			<i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Предпросмотр
		</button>
		<button class="btn btn-default btn-lg">
			<i class="fa fa-print"></i>&nbsp;&nbsp;Печать
		</button>
	</div>
</div>
</div>