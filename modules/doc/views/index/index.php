<?php
/**
 * @var $this yii\web\View
 */
?>

<div class="col-xs-9">
	<div class="panel panel-default table-view">
		<div class="panel-heading">
			Список документов
		</div>
		<div class="panel-body table-widget">
			<?= \app\widgets\AutoTable::widget([
				"provider" => \app\core\TableProviderAdapter::createProvider(
					new \app\models\User(), new \app\forms\UserForm("table"), []
				)
			]) ?>
		</div>
	</div>
</div>
<div class="col-xs-3">

</div>