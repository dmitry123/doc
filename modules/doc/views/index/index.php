<?php
/**
 * @var $this yii\web\View
 */
print \app\widgets\Modal::widget([
	"title" => "Загрузка документов",
	"body" => \yii\helpers\Html::input("file", "files[]", null, [
		"id" => "document-file-upload",
		"multiple" => "true",
		"class" => "file-loading",
		"name" => "files[]"
	]),
	"id" => "file-upload-modal",
	"size" => "modal-lg",
	"wrapper" => "col-xs-12"
]); ?>

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
						"keys" => [ "name", "upload_time", "employee_id", "status" ],
						"order" => "name"
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