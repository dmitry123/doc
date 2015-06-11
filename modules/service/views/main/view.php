<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\service\controllers\MainController
 * @var $ext string
 * @var $items array
 */
?>
<div class='col-xs-3'>
	<?= \app\widgets\Panel::widget([
		'body' => \app\widgets\TabMenu::create([
			'items' => $items,
			'id' => 'service-module-menu',
			'style' => \app\widgets\TabMenu::STYLE_PILLS_STACKED
		]),
		'title' => 'Модули',
		'bodyClass' => 'panel-body clear',
		'upgradable' => false,
		'footer' => \yii\bootstrap\Progress::widget([
			'id' => 'service-module-progress',
			'options' => [ 'class' => 'clear' ]
		]),
		'controls' => [
			'service-refresh-icon' => [
				'label' => 'Обновить страницу',
				'icon' => 'glyphicon glyphicon-refresh',
			]
		],
		'controlMode' => \app\widgets\ControlMenu::MODE_ICON,
	]) ?>
</div>
<div class='col-xs-9' id='service-module-content'>
	<?php if ($ext != null): ?>
		<?= \app\core\ExtFactory::getFactory()->invoke($ext['module'], $ext['id'], '', $ext['params']) ?>
	<?php else: ?>
		<h3>Здесь будут отображаться компоненты внедрения для каждого модуля</h3>
		<h4>Для загрузки компонента, необходимо выбрать соответствующий элемент из списка элементов модулей</h4>
	<?php endif ?>
</div>