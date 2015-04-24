<?php
/**
 * @var $this yii\web\View
 * @var $modules array
 * @var $name string
 */
?>

<div class="col-xs-12 module-menu-block">
	<div class="col-xs-1 module-menu-block-cell no-padding text-center">
		<div class="module-menu-block-icon-wrapper">
			<span class="glyphicon glyphicon-home module-menu-block-icon" data-placement="bottom" data-original-title="Домой" onmouseenter="$(this).tooltip('show')"></span>
		</div>
	</div>
<?php foreach ($modules as $module): ?>
	<div class="col-xs-1 module-menu-block-cell no-padding text-center">
		<div class="module-menu-block-icon-wrapper" <?= \yii\helpers\Html::renderTagAttributes($module["options"]) ?>>
			<span class="<?= $module["icon"] ?> module-menu-block-icon" data-placement="bottom" data-original-title="<?= $module["name"] ?>" onmouseenter="$(this).tooltip('show')"></span>
		</div>
	</div>
<?php endforeach; ?>
</div>