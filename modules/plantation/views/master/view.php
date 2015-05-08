<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\plantation\controllers\MasterController
 */

print \yii\helpers\Html::tag("div", \app\widgets\Grid::widget([
	"provider" => new \app\tables\FileTable()
]), [ "class" => "col-xs-6" ]);

print \yii\helpers\Html::tag("div", \app\widgets\Grid::widget([
	"provider" => new \app\tables\EmployeeTable()
]), [ "class" => "col-xs-6" ]);
