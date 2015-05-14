<?php
/**
 * @var $this yii\web\View
 */

\app\components\widgets\Logo::begin([
	"controls" => [
		"employee-send-button" => [
			"label" => "Отправить",
			"icon" => "glyphicon glyphicon-send",
			"class" => "btn btn-primary btn-block",
			"type" => "button"
		],
		"employee-logout-button" => [
			"label" => "Выйти",
			"icon" => "glyphicon glyphicon-log-out",
			"class" => "btn btn-danger btn-block",
			"type" => "button"
		]
	]
]);

print \app\components\widgets\Form::widget([
	"model" => new \app\components\forms\EmployeeForm("register")
]);

\app\components\widgets\Logo::end();