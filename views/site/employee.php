<?php
/**
 * @var $this yii\web\View
 */

\app\widgets\Logo::begin([
	"buttons" => [
		"send-button" => [
			"text" => "Отправить",
			"class" => "btn btn-primary btn-block",
			"type" => "button"
		],
		"block-logout" => [
			"text" => "Выйти",
			"class" => "btn btn-danger btn-block",
			"type" => "button"
		]
	]
]);

print \app\widgets\Form::widget([
	"model" => new \app\forms\EmployeeForm("register")
]);

\app\widgets\Logo::end();