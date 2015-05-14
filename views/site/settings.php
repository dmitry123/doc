<?php
/**
 * @var $this yii\web\View
 * @var $modules array
 */
print \app\components\widgets\Logo::widget([
	"body" => \app\components\widgets\AutoForm::widget([
		"model" => \app\components\forms\EmployeeForm::createWithScenario("setup")
	]),
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