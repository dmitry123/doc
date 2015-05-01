<?php
/**
 * @var $this View
 * @var $modules array
 */
use yii\web\View;

\app\widgets\Logo::begin([
	"controls" => [
		"register-save-button" => [
			"label" => "Регистрация",
			"icon" => "glyphicon glyphicon-log-in",
			"class" => "btn btn-primary btn-block",
			"type" => "button"
		],
		"register-cancel-button" => [
			"label" => "Назад",
			"icon" => "glyphicon glyphicon-arrow-left",
			"class" => "btn btn-default btn-block",
			"type" => "button"
		]
	]
]);
print \app\widgets\Form::widget([
	"model" => new \app\forms\UserForm("register"),
	"url" => Yii::$app->getUrlManager()->createUrl("user/register"),
	"id" => "user-register-form"
]);
\app\widgets\Logo::end();