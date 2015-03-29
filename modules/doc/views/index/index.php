<?php
/**
 * @var $this yii\web\View
 */
print \app\widgets\Modal::widget([
	"title" => "Hello",
	"id" => "test-modal"
]);
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
	<?= \app\modules\doc\widgets\BasicActions::widget([]) ?>
	<?= \app\modules\doc\widgets\AboutDocument::widget([]) ?>
</div>