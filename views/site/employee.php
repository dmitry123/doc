<?php
/**
 * @var $this yii\web\View
 */

print \yii\helpers\Html::tag("div", \app\widgets\Form::widget([
	"model" => new \app\forms\EmployeeForm("register")
]), [
	"style" => "width: 350px"
]);