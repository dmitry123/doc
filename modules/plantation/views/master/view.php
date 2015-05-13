<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\plantation\controllers\MasterController
 */
?>
<div class="col-xs-3">
	<?= \app\widgets\Panel::widget([
		"body" => \app\widgets\TabMenu::create([
			"items" => \app\core\ModuleHelper::getHrefModules(false),
			"style" => \app\widgets\TabMenu::STYLE_PILLS_STACKED
		]),
		"title" => "Модули",
		"bodyClass" => "panel-body clear",
		"upgradeable" => false
	]) ?>
</div>
<div class="col-xs-9">
	<?= \app\widgets\Panel::widget([
		"upgradeable" => false
	])?>
</div>