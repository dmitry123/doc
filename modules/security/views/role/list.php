<?php
/**
 * @var $view \yii\web\View
 */
print \app\widgets\Grid::widget([
	"provider" => new \app\grids\EmployeeGridProvider()
]);