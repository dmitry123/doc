<?php
/**
 * @var $this yii\web\View
 */
print \app\widgets\Modal::widget([
    "title" => "Шаблоны документа",
    "body" => \yii\helpers\Html::tag("h1", "Документ не выбран", [
        "class" => "text-center"
    ]),
    "id" => "doc-file-template-manager-modal"
]) ?>
<div class="col-xs-12 clear">
	<div class="col-xs-7">
	<?= \app\widgets\Panel::widget([
		"title" => "Список файлов",
		"body" => \app\widgets\Grid::create([
			"provider" => new \app\modules\doc\grids\FileDocumentGridProvider()
		]),
		"controls" => [
			"doc-file-upload-icon" => [
				"label" => "Загрузить",
				"class" => "btn btn-primary btn-sm",
				"icon" => "fa fa-upload",
				"data-toggle" => "modal",
				"data-target" => "#file-upload-modal"
			]
		],
		"bodyClass" => "panel-body clear"
	]) ?>
	</div>
	<div class="col-xs-5">
		<?= \app\widgets\Panel::widget([
			"title" => "Информация",
			"body" => \app\modules\doc\widgets\AboutFile::create(),
			"panelClass" => "panel panel-default doc-about-file-panel",
			"upgradable" => false,
		]) ?>
	</div>
</div>