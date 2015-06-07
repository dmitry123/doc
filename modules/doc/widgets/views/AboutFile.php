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
?>
<div class="doc-about-file-wrapper">
<?php $panel = \app\widgets\Panel::begin([
	'title' => 'Описание',
	'controls' => [

	],
	'controlMode' => \app\widgets\ControlMenu::MODE_BUTTON,
	'footer' => \app\widgets\ControlMenu::widget([
		'controls' => [
			'doc-about-file-download-icon' => [
				'label' => 'Скачать',
				'class' => 'btn btn-primary btn-sm',
				'icon' => 'fa fa-download',
				'data-id' => $file->{'id'},
			],
			'doc-about-file-template-icon' => [
				'label' => 'Шаблоны',
				'class' => 'btn btn-default btn-sm',
				'icon' => 'fa fa-cloud-download',
				'data-id' => $file->{'id'},
			],
			'doc-about-file-remove-icon' => [
				'label' => 'Удалить',
				'class' => 'btn btn-danger btn-sm',
				'icon' => 'fa fa-trash',
				'onclick' => 'confirmDelete("Вы уверены что хотите удалить этот документ? Так же будут удалены все зависимые элементы документа - шаблоны или файлы загрузок")',
				'data-id' => $file->{'id'},
			]
		],
		'placement' => 'bottom',
		'mode' => \app\widgets\ControlMenu::MODE_GROUP,
	]),
	'panelClass' => 'panel panel-default doc-about-file-panel',
]) ?>
<div class='row clear'>
	<div class='col-xs-4 text-left'><b>Название</b></div>
	<div class='col-xs-8 text-left'><?= $string ?></div>
</div>
<div class='row clear'>
	<div class='col-xs-4 text-left'><b>Загрузил</b></div>
	<div class='col-xs-8 text-left'><?= $employee->{'surname'}.' '.$employee->{'name'}.' '.$employee->{'patronymic'} ?></div>
</div>
<div class='row clear'>
	<div class='col-xs-4 text-left'><b>Дата загрузки</b></div>
	<div class='col-xs-8 text-left'><?= $file->{'upload_date'}.' '.$file->{'upload_time'} ?></div>
</div>
<div class='row clear'>
	<div class='col-xs-4 text-left'><b>Статус файла</b></div>
	<div class='col-xs-8 text-left'><?= $status->{'name'} ?></div>
</div>
<div class='row clear'>
	<div class='col-xs-4 text-left'><b>Тип файла</b></div>
	<div class='col-xs-8 text-left'><?= $type->{'name'} ?></div>
</div>
<div class='row clear'>
	<div class='col-xs-4 text-left'><b>Расширение</b></div>
	<div class='col-xs-8 text-left'><?= $ext->{'ext'} ?></div>
</div>
<?php $panel->end() ?>
<?= \app\modules\doc\widgets\FileManager::widget([
	'file' => $file
]) ?>
</div>