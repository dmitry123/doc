<?php
/**
 * @var $this yii\web\View
 * @var $modules array
 */
\app\widgets\Logo::begin([
	"controls" => [
		"settings-save-button" => [
			"label" => "Сохранить",
			"icon" => "glyphicon glyphicon-save",
			"class" => "btn btn-primary btn-block",
			"type" => "button"
		],
		"settings-back-button" => [
			"label" => "Отмена",
			"icon" => "glyphicon glyphicon-remove",
			"class" => "btn btn-default btn-block",
			"type" => "button"
		]
	]
]);
print \app\widgets\Form::widget([
	"model" => new \app\forms\EmployeeForm()
]);
\app\widgets\Logo::end();