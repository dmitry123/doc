<?php
/**
 * @var $this View
 */
use yii\web\View;

print \app\widgets\Modal::widget([
	"title" => "Изменение "
]); ?>

<div class="col-xs-9">
	<div class="panel panel-default table-view">
		<div class="panel-heading">
			Список текущих значений
		</div>
		<div class="panel-body table-widget">
			<?= \app\modules\admin\widgets\Table::widget([
				"provider" => new \app\models\User()
			]) ?>
		</div>
	</div>
</div>
<div class="col-xs-3">
	<?= \app\modules\admin\widgets\TableView::widget() ?>
</div>