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
<div class="col-xs-12">
	<div class="col-xs-8 clear">
	<?= \app\widgets\Panel::widget([
		"title" => "Список файлов",
		"body" => \app\widgets\Grid::create([
			"provider" => new \app\modules\doc\grids\File_DocumentTable_GridProvider()
		]),
		"bodyClass" => "panel-body clear"
	]) ?>
	</div>
	<div class="col-xs-4">
		<?= \app\widgets\Panel::widget([
			"title" => "Тип файла"
		]) ?>
		<hr>
		<?= \app\widgets\Panel::widget([
			"title" => "Информация"
		]) ?>
		<hr>
		<?= \app\widgets\Panel::widget([
			"title" => "История"
		]) ?>
	</div>
</div>