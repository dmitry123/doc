<?php
/**
 * @var $this yii\web\View
 */
?>

<div class="col-xs-9 admin-table-panel-wrapper">
	<?= \app\widgets\Panel::widget([
		"title" => "Список текущих значений",
		"id" => "admin-table-view-panel",
		"body" => \app\modules\admin\widgets\TablePanel::create(),
		"controls" => [
			"panel-update-button" => [
				"class" => "btn btn-default btn-sm",
				"label" => "<span class=\"glyphicon glyphicon-refresh\"></span>&nbsp;&nbsp;Обновить",
				"onclick" => "$(this).panel('update')",
			],
			"panel-insert-button" => [
				"class" => "btn btn-primary btn-sm",
				"label" => "<span class=\"glyphicon glyphicon-plus\"></span>&nbsp;&nbsp;Добавить",
				"onclick" => "$('#table-save-modal').modal('show')",
			]
		],
		"bodyClass" => "panel-body no-padding panel-body-fix"
	]) ?>
</div>
<div class="col-xs-3">
	<?= \app\widgets\Panel::widget([
		"title" => "Таблицы",
		"body" => \app\modules\admin\widgets\TableMenu::create(),
		"id" => "admin-table-menu"
	]) ?>
</div>