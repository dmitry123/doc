<?php
/**
 * @var $this \yii\web\View
 */

use app\modules\doc\grids\File_DocumentTable_GridProvider;

print \app\widgets\Modal::widget([
	"title" => "Список файлов",
	"body" => \app\widgets\Grid::widget([
		"provider" => new File_DocumentTable_GridProvider()
	]),
	"size" => \app\widgets\Modal::SIZE_LARGE,
	"id" => "doc-editor-file-table-modal",
]);
print \app\widgets\Modal::widget([
    "title" => "Шаблоны документа",
    "body" => \yii\helpers\Html::tag("h1", "Документ не выбран", [
        "class" => "text-center"
    ]),
    "id" => "doc-file-template-manager-modal"
]) ?>
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