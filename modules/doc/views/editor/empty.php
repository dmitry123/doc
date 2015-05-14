<?php
/**
 * @var $this \yii\web\View
 */
print \app\components\widgets\Modal::widget([
	"title" => "Список файлов",
	"body" => \app\components\widgets\Grid::widget([
		"provider" => new \app\components\tables\FileTable()
	]),
	"size" => \app\components\widgets\Modal::SIZE_LARGE,
	"id" => "doc-editor-file-table-modal",
]); ?>
<div class="col-xs-12 text-center">
	<h1>Файл для создания шаблона не выбран</h1>
	<br>
	<a href="<?= Yii::$app->getUrlManager()->createUrl("doc/file/view") ?>" class="btn btn-default btn-lg">
		<i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Назад
	</a>
	<button class="btn btn-default btn-lg" data-toggle="modal" data-target="#doc-editor-file-table-modal">
		<i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Выбрать файл
	</button>
</div>