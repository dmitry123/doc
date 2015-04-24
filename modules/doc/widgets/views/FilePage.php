<?php
/**
 * @var $this \yii\web\View
 * @var $self app\modules\doc\widgets\FilePage
 */
?>

<div class="col-xs-9">
<?= \app\widgets\Panel::widget([
	"title" => $self->textList,
	"body" => \app\modules\doc\widgets\FileTable::create(),
	"bodyClass" => "panel-body text-center no-padding table-widget panel-body-fix",
]) ?>
</div>
<div class="col-xs-3">
<?= \app\widgets\Panel::widget([
	"title" => "Тип файла",
	"bodyClass" => "panel-body text-center file-type-menu-wrapper panel-body-fix",
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