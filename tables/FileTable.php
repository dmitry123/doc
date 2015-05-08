<?php

namespace app\tables;

use app\core\Table;
use app\models\doc\File;

class FileTable extends Table {

	public $columns = [
		"id" => "#",
		"file_ext_id" => "Расширение",
		"name" => "Название",
		"upload_date" => "Дата загрузки",
		"upload_time" => "Время загрузки",
	];

	public $menu = [
		"controls" => [
			"table-edit-icon" => [
				"label" => "Редактировать",
				"icon" => "glyphicon glyphicon-pencil"
			]
		],
		"mode" => \app\widgets\ControlMenu::MODE_ICON
	];

	public $pagination = [
		"pageSize" => 5,
		"page" => 0
	];

	public $primaryKey = "id";

	public $sort = [
		"attributes" => [
			"id", "file_ext_id", "name", "upload_date"
		],
		"defaultOrder" => [
			"id" => SORT_ASC
		]
	];

	public function getQuery() {
		return File::find();
	}
}