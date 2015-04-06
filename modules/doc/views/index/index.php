<?php
/**
 * @var $this yii\web\View
 */
\app\widgets\Modal::begin([
	"title" => "Загрузка документов",
	"id" => "file-upload-modal",
	"size" => "modal-lg",
	"wrapper" => "col-xs-12"
]);

print \yii\helpers\Html::tag("div", \app\widgets\Form::widget([
	"model" => new \app\core\FormModelAdapter("default", [
		"category" => [
			"label" => "Категория",
			"type" => "DropDown",
			"table" => [
				"name" => "doc.category",
				"key" => "id",
				"value" => "name"
			]
		],
		"status" => [
			"label" => "Статус",
			"type" => "DocumentStatus"
		]
	])
]), [
	"class" => "row",
	"style" => "margin-bottom: 10px"
]);

print \yii\helpers\Html::input("file", "files[]", null, [
	"id" => "document-file-upload",
	"multiple" => "true",
	"class" => "file-loading",
	"name" => "files[]"
]);

\app\widgets\Modal::end();
?>

<div class="col-xs-9">
	<div class="panel panel-default table-view">
		<div class="panel-heading row">
			<div class="col-xs-12">
				<div class="col-xs-6 text-left">
					Список документов
				</div>
				<div class="col-xs-6 text-right doc-plus-wrapper">
				</div>
			</div>
		</div>
		<div class="panel-body table-widget">
			<?= \app\widgets\AutoTable::widget([
				"provider" => \app\core\TableProviderAdapter::createProvider(
					new \app\models\Document(), new \app\forms\DocumentForm("table"), [
						"keys" => [ "name", "upload_date", "employee_id", "status" ]
					]
				), "controls" => false
			]) ?>
		</div>
	</div>
</div>
<div class="col-xs-3">
	<?= \app\widgets\Panel::widget([
		"title" => "Информация о документе",
		"body" => \app\modules\doc\widgets\AboutDocument::widget([]),
		"align" => "text-center"
	]) ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<span>История изменений документа</span>
		</div>
		<div class="panel-body text-center">
			<?= \app\modules\doc\widgets\DocumentHistory::widget([]) ?>
		</div>
	</div>
</div>