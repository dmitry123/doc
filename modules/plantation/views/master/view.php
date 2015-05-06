<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\plantation\controllers\MasterController
 */

print \app\widgets\Grid::widget([
	"provider" => $p = new \app\core\ActiveDataProvider([
		"query" => \app\models\core\Employee::find(),
		"columns" => [
			"id" => "#",
			"surname" => "Фамилия",
			"name" => "Имя",
			"patronymic" => "Отчество"
		],
		"pagination" => [
			"pageSize" => 1
		],
		"sort" => [
			"attributes" => [
				"id", "surname", "name", "patronymic"
			],
			"defaultOrder" => [
				"surname" => SORT_ASC
			]
		],
		"primaryKey" => "id"
	]),
	"menu" => [
		"controls" => [
			"table-edit-icon" => [
				"label" => "Редактировать",
				"icon" => "glyphicon glyphicon-pencil"
			]
		],
		"mode" => \app\widgets\ControlMenu::MODE_ICON
	],
]);

//print \yii\grid\GridView::widget([
//	"dataProvider" => $provider,
//	"columns" => [
//		"id", "surname", "name", "patronymic", "login"
//	]
//]);

//print \app\widgets\MasterMenu::widget([
//	"id" => "plantation-master-menu",
//	"ext" => "plantation"
//]);