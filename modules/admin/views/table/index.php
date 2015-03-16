<?php

/**
 * @var $this View
 */

use yii\web\View;

print \yii\helpers\Html::tag("div", \app\modules\admin\widgets\Table::widget([
	"provider" => new \app\models\User()
]), [
	"class" => "col-xs-9"
]);

print \yii\helpers\Html::tag("div", \app\modules\admin\widgets\TableView::widget(), [
	"class" => "col-xs-3"
]);