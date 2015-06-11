<?php
/**
 * @var $this yii\web\View
 * @var $ext app\modules\security\extensions\Service
 * @var $provider app\core\GridProvider
 */
print \app\widgets\PanelEx::widget([
	'body' => \app\widgets\Grid::create([
		'provider' => 'app\modules\security\grids\\'.$provider
	])
]);