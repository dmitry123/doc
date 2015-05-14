<?php

use yii\web\View;

/**
 * @var View $this
 */

print \yii\helpers\Html::beginTag("div", [
	"style" => "width: 500px"
]);
print \app\components\widgets\Form::widget([
	"model" => new \app\components\forms\EmployeeForm("register")
]);
print \yii\helpers\Html::endTag("div");