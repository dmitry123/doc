<?php
/**
 * @var $this \yii\web\View
 * @var $self app\modules\doc\widgets\FilePage
 */
?>

<div class="col-xs-9">
<?= \app\widgets\Panel::widget([
	"title" => $self->textList,
	"body" =>\app\widgets\Table::create([
		"provider" => get_class($self->tableActiveRecord),
		"header" => [
			"file_type_id" => [
				"label" => "Тип файла",
				"style" => "width: 125px"
			],
			"name" => [
				"label" => "Наименование"
			],
			"upload_date" => [
				"label" => "Дата загрузки"
			]
		],
		"controls" => [
			"file-configure-icon" => [
				"class" => "glyphicon glyphicon-cog",
				"tooltip" => "Настроить файл"
			],
			"template-create-icon" => [
				"class" => "glyphicon glyphicon-list-alt",
				"tooltip" => "Создать шаблон"
			],
			"file-lock-icon" => [
				"class" => "glyphicon glyphicon-lock",
				"tooltip" => "Заблокировать файл"
			]
		],
		"orderBy" => "upload_date",
		"controlsWidth" => 150
	]),
	"bodyClass" => "panel-body text-center no-padding table-widget",
]) ?>
</div>
<div class="col-xs-3">
<?= \app\widgets\Panel::widget([
	"title" => "Тип файла",
	"bodyClass" => "panel-body text-center file-type-menu-wrapper",
	"body" => \app\modules\doc\widgets\FileTypeMenu::create([]),
]) ?>
<hr>
<?= \app\widgets\Panel::widget([
	"title" => $self->textInfo,
	"body" => \app\modules\doc\widgets\AboutFile::create([
		"id" => null
	])
]) ?>
<hr>
<?= \app\widgets\Panel::widget([
	"title" => $self->textHistory,
	"body" => \app\modules\doc\widgets\FileHistory::create([
		"id" => null
	])
]) ?>
</div>