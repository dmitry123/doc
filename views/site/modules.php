<?
/**
 * @var $this View
 * @var $modules array
 */
use yii\web\View;
?>

<div class="col-xs-12">
	<?php foreach ($modules as $module): ?>
		<div class="col-xs-6 module-cell">
			<div class="module-icon-wrapper" <?= \yii\helpers\Html::renderTagAttributes($module["options"]) ?>>
				<span class="<?= $module["icon"] ?> module-icon"></span>
				<div class="module-title">
					<?= $module["name"] ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>