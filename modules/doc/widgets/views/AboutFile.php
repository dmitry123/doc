<?php
/**
 * @var $this yii\web\View
 * @var $string string
 * @var $file app\models\doc\File
 * @var $columns string[]
 * @var $ext app\models\doc\FileExt
 * @var $status app\models\doc\FileStatus
 * @var $type app\models\doc\FileType
 * @var $employee app\models\core\Employee
 */
ob_start() ?>
<div class="col-xs-12 text-right">
	<h4 class="clear"><b><?= $string ?></b></h4>
</div>
<? $panel = \app\widgets\Panel::begin([
	"title" => ob_get_clean(),
	"titleWrapperClass" => "row clear",
	"controlsWrapperClass" => "",
	"footer" => \app\widgets\ControlMenu::widget([
		"controls" => [
			"doc-about-file-download-icon" => [
				"label" => "Скачать",
				"class" => "btn btn-primary btn-sm",
				"icon" => "fa fa-download",
				"data-id" => $file->{"id"},
			],
			"doc-about-file-export-icon" => [
				"label" => "Конвертировать",
				"class" => "btn btn-default btn-sm",
				"icon" => "fa fa-cloud-download",
				"data-id" => $file->{"id"},
			],
			"doc-about-file-template-icon" => [
				"label" => "Шаблоны",
				"class" => "btn btn-default btn-sm",
				"icon" => "fa fa-cloud-download",
				"data-id" => $file->{"id"},
			],
			"doc-about-file-remove-icon" => [
				"label" => "Удалить",
				"class" => "btn btn-danger btn-sm",
				"icon" => "fa fa-trash",
				"onclick" => "confirmDelete()",
				"data-id" => $file->{"id"},
			]
		],
		"placement" => "bottom",
		"mode" => \app\widgets\ControlMenu::MODE_GROUP,
	]),
	"panelClass" => "panel panel-default doc-about-file-panel",
]) ?>
<div class="row clear">
	<div class="col-xs-6 text-left"><b>Загрузил</b></div>
	<div class="col-xs-6 text-left"><?= $employee->{"surname"}." ".$employee->{"name"}." ".$employee->{"patronymic"} ?></div>
</div>
<div class="row clear">
	<div class="col-xs-6 text-left"><b>Дата загрузки</b></div>
	<div class="col-xs-6 text-left"><?= $file->{"upload_date"} ?></div>
</div>
<div class="row clear">
	<div class="col-xs-6 text-left"><b>Время загрузки</b></div>
	<div class="col-xs-6 text-left"><?= $file->{"upload_time"} ?></div>
</div>
<div class="row clear">
	<div class="col-xs-6 text-left"><b>Расширение</b></div>
	<div class="col-xs-6 text-left"><?= $ext->{"ext"} ?></div>
</div>
<div class="row clear">
	<div class="col-xs-6 text-left"><b>Статус файла</b></div>
	<div class="col-xs-6 text-left"><?= $status->{"name"} ?></div>
</div>
<div class="row clear">
	<div class="col-xs-6 text-left"><b>Тип файла</b></div>
	<div class="col-xs-6 text-left"><?= $type->{"name"} ?></div>
</div>
<?php $panel->end() ?>