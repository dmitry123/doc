<?php
/**
 * @var $this yii\web\View
 * @var $modules array
 * @var $name string
 */
?>
<div class="col-xs-12 module-menu-block">
	<div class="col-xs-3 module-menu-block-cell no-padding text-center">
		<div class="module-menu-block-icon-wrapper" data-url="<?= Yii::$app->getHomeUrl() ?>">
			<span class="glyphicon glyphicon-home module-menu-block-icon"></span>
			<br>
			<span class="module-menu-icon-text">Домой</span>
		</div>
	</div>
<?php foreach ($modules as $module): ?>
	<div class="col-xs-3 module-menu-block-cell no-padding text-center">
		<div class="module-menu-block-icon-wrapper" <?= \yii\helpers\Html::renderTagAttributes($module["options"]) ?>>
			<span class="<?= $module["icon"] ?> module-menu-block-icon"></span>
			<br>
			<span class="module-menu-icon-text"><?= $module["name"] ?></span>
		</div>
	</div>
<?php endforeach; ?>
</div>