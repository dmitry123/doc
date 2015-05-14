<?php
/**
 * @var $items array
 * @var $id string
 * @var $ext string
 */
?>
<div class="master-menu-wrapper" data-ext="<?= $ext ?>">
	<div class="col-xs-3 master-menu-list">
	<?= \app\components\widgets\Panel::widget([
		"title" => "Выберите модуль",
		"body" => \app\components\widgets\TabMenu::widget([
			"style" => \app\components\widgets\TabMenu::STYLE_PILLS_STACKED,
			"items" => $items,
		]),
		"controls" => [
			"master-list-icon" => [
				"label" => "Список",
				"icon" => "glyphicon glyphicon-list",
				"parent" => [
					"class" => "active"
				]
			],
			"master-normal-icon" => [
				"label" => "Матрица",
				"icon" => "glyphicon glyphicon-th",
			],
			"mater-large-icon" => [
				"label" => "Иконки",
				"icon" => "glyphicon glyphicon-th-large",
			]
		],
		"bodyClass" => "panel-body no-padding",
		"controlMode" => \app\components\widgets\ControlMenu::MODE_MENU,
		"id" => $id
	]); ?>
	</div>
	<div class="col-xs-9 master-menu-body">
		<h1 class="text-center">Модуль не выбран</h1>
	</div>
</div>