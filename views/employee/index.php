<?php

use yii\web\View;

/**
 * @var View $this
 */

print \yii\helpers\Html::beginTag("div", [
	"style" => "width: 500px"
]);
print \app\widgets\Form::widget([
	"model" => new \app\forms\EmployeeForm("register")
]);
print \yii\helpers\Html::endTag("div");