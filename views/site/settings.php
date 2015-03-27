<?php
/**
 * @var $this View
 * @var $modules array
 */
use yii\web\View;

\app\widgets\Logo::begin([
	"buttons" => [
		"settings-save" => [
			"text" => "Сохранить",
			"class" => "btn btn-primary btn-block",
			"type" => "button"
		],
		"modules-button" => [
			"text" => "Отмена",
			"class" => "btn btn-default btn-block",
			"type" => "button"
		]
	]
]);

print \app\widgets\Form::widget([
	"model" => new \app\forms\EmployeeForm()
]);

\app\widgets\Logo::end();