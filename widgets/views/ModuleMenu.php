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
		<span>МГУП<?= $name ?>&nbsp;<span class="caret"></span></span>
	</h2>
	<ul class="nav nav-pills nav-stacked module-menu-list">
		<li role="presentation" data-url="/">
			<span class="glyphicon glyphicon-home">&nbsp;</span>
			<span>Домой</span>
		</li>
		<?php foreach ($modules as $module): ?>
			<li role="presentation" <?= \yii\helpers\Html::renderTagAttributes($module["options"]) ?>>
				<span class="<?= $module["icon"] ?>">&nbsp;</span>
				<span><?= $module["name"] ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</div>