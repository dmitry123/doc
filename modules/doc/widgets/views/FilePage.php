<?php
/**
 * @var $this \yii\web\View
 * @var $self app\modules\doc\widgets\FilePage
 */
?>

<div class="col-xs-9">
	<?php \app\widgets\Panel::begin([
		"title" => $self->textList,
		"bodyClass" => "panel-body text-center no-padding table-widget",
	]) ?>
	<?= \app\widgets\AutoTable::widget([
		"provider" => \app\core\TableProviderAdapter::createProvider(
			$self->tableActiveRecord, new \app\forms\FileForm("table"), [
				"keys" => [ "name", "upload_time", "employee_id", "file_status_id" ],
				"order" => "upload_time desc"
			]
		), "controls" => false
	]) ?>
	<?php \app\widgets\Panel::end() ?>
</div>
<div class="col-xs-3">
	<?= \app\widgets\Panel::widget([
		"title" => "Тип файла",
		"bodyClass" => "panel-body text-center file-type-menu-wrapper",
		"body" => \app\modules\doc\widgets\FileTypeMenu::widget()
	]) ?>
	<?= \app\widgets\Panel::widget([
		"title" => $self->textInfo,
		"body" => \app\modules\doc\widgets\AboutFile::widget([])
	]) ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<span><?= $self->textHistory ?></span>
		</div>
		<div class="panel-body text-center">
			<?= \app\modules\doc\widgets\FileHistory::widget([]) ?>
		</div>
	</div>
</div>