<?php
/**
 * @var $this View
 * @var $modules array
 */
use yii\web\View;

print \app\components\widgets\Logo::widget([
	"body" => \app\components\widgets\AutoForm::widget([
		"model" => \app\components\forms\UserForm::createWithScenario("register"),
		"url" => "user/register",
		"id" => "user-register-form",
		"except" => [
			"access_token"
		]
	]),
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