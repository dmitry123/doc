<?php
/**
 * @var $items array
 * @var $id string
 */
?>
<div class="col-xs-3">
	<?= \app\widgets\Panel::widget([
		"title" => "Выберите модуль",
		"body" => \app\widgets\TabMenu::widget([
			"style" => \app\widgets\TabMenu::STYLE_PILLS_STACKED,
			"items" => $items,
		]),
		"controls" => [
			"master-list-icon" => [
				"label" => "Список",
				"icon" => "glyphicon glyphicon-list"
			],
			"master-normal-icon" => [
				"label" => "Матрица",
				"icon" => "glyphicon glyphicon-th"
			],
			"mater-large-icon" => [
				"label" => "Иконки",
				"icon" => "glyphicon glyphicon-th-large"
			]
		],
		"controlMode" => \app\widgets\ControlMenu::MODE_MENU,
		"id" => $id
	]); ?>
</div>
<div class="col-xs-9">
	<h1 class="text-center">Модуль не выбран</h1>
</div>