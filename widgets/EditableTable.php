<?php

namespace app\widgets;

use yii\helpers\ArrayHelper;

class EditableTable extends Table {

	public $controls = [
		"table-edit-icon" => [
			"label" => "Редактировать",
			"icon" => "glyphicon glyphicon-pencil"
		],
		"table-remove-icon" => [
			"label" => "Удалить",
			"icon" => "glyphicon glyphicon-remove confirm-delete font-red"
		]
	];

	public $controlsWidth = 100;
	public $pageLimit = 10;

	public function getSerializedAttributes($attributes = null, $excepts = []) {
		return parent::getSerializedAttributes($attributes, ArrayHelper::merge($excepts, [
				"controls", "controlsWidth"
			]));
	}
}