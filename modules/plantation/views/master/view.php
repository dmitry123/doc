<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\plantation\controllers\MasterController
 */
?>
<div class="col-xs-3">
	<?= \app\widgets\Panel::widget([
		"body" => \app\widgets\TabMenu::create([
			"items" => \app\core\ModuleHelper::getTabModulesEx(function($id, $module) {
				return $module + [
					"items" => \app\core\ExtFactory::getFactory()->loadIfCan($id, "PlantationMenu", []),
					"data-module" => $id,
				];
			}, false),
			"id" => "plantation-module-menu",
			"style" => \app\widgets\TabMenu::STYLE_PILLS_STACKED
		]),
		"title" => "Модули",
		"bodyClass" => "panel-body clear",
		"upgradeable" => false
	]) ?>
</div>
<div class="col-xs-9" id="plantation-module-content">
	<h3>Здесь будут отображаться компоненты внедрения для каждого модуля</h3>
	<h4>Для загрузки компонента, необходимо выбрать соответствующий элемент из списка элементов модулей</h4>
</div>