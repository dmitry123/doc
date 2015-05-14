<?php
/**
 * @var $this yii\web\View
 * @var $modules array
 * @var $name string
 */
?>

<div class="module-menu-heading row" data-load="block">
	<ul class="nav nav-pills nav-stacked module-menu-list">
		<li role="presentation" data-url="/">
			<span class="glyphicon glyphicon-home"></span>
			<span> | Домой</span>
		</li>
		<?php foreach ($modules as $module): ?>
			<li role="presentation" <?= \yii\helpers\Html::renderTagAttributes($module["options"]) ?>>
				<span class="<?= $module["icon"] ?>"></span>
				<span> | <?= $module["name"] ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</div>