<?php
/**
 * @var $this View
 * @var $modules array
 * @var $name string
 */
use yii\web\View;

?>

<div class="module-menu-heading" data-load="block">
	<h2 class="module-menu-title text-center">
		<span>МГУП<?= $name ?></span>
<!--		<span class="glyphicon glyphicon-menu-down"></span>-->
	</h2>
	<ul class="nav nav-pills nav-stacked module-menu-list">
		<li role="presentation" data-url="<?= Yii::$app->getHomeUrl() ?>">
			<span class="glyphicon glyphicon-home">&nbsp;</span>
			<span>Домой</span>
		</li>
		<? foreach ($modules as $module): ?>
			<li role="presentation" <?= \yii\helpers\Html::renderTagAttributes($module["options"]) ?>>
				<span class="<?= $module["icon"] ?>">&nbsp;</span>
				<span><?= $module["name"] ?></span>
			</li>
		<? endforeach; ?>
	</ul>
</div>