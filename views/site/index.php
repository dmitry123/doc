<?php
/**
 * @var $this yii\web\View - Render instance
 */

echo \app\widgets\Modal::widget([
	"id" => "login-modal",
	"title" => "Вход",
	"body" => \app\widgets\Form::widget([
		"model" => new \app\forms\LoginForm("login")
	]),
	"buttons" => [
		"register-button" => [
			"class" => "btn btn-primary",
			"text" => "Сохранить",
			"type" => "submit"
		]
	]
]); ?>

<button class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Click On Me</button>