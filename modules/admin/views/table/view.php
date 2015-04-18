<?php
/**
 * @var $this View
 */
use yii\web\View;

print \app\widgets\Modal::widget([
	"title" => "Редактирование \"<span></span>\"",
	"buttons" => [
		"table-save-button" => [
			"text" => " Сохранить",
			"class" => "btn btn-primary",
			"type" => "submit"
		]
	],
	"id" => "table-edit-modal"
]); ?>

<div class="col-xs-9 admin-table-panel-wrapper">
	<?= \app\modules\admin\widgets\TablePanel::widget([
		"model" => new \app\models\User(),
		"form" => new \app\forms\UserForm("table")
	]) ?>
</div>
<div class="col-xs-3">
	<?= \app\modules\admin\widgets\TableView::widget() ?>
</div>