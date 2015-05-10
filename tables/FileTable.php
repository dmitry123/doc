<?php

namespace app\tables;

use app\core\Table;
use app\models\doc\File;

class FileTable extends Table {

	public $columns = [
		"id" => "#",
		"name" => "Название",
		"file_ext_id" => "Расширение",
		"upload_date" => "Дата загрузки",
		"upload_time" => "Время загрузки"
	];

	public $menu = [
		"controls" => [
			"table-edit-icon" => [
				"label" => "Редактировать",
				"icon" => "glyphicon glyphicon-pencil"
			],
			"table-remove-icon" => [
				"label" => "Удалить",
				"icon" => "glyphicon glyphicon-remove"
			]
		],
		"mode" => \app\widgets\ControlMenu::MODE_ICON
	];

	public $pagination = [
		"pageSize" => 5,
		"page" => 0
	];

	public $sort = [
		"attributes" => [
			"id", "name", "file_ext_id", "upload_date", "upload_time"
		],
		"orderBy" => [
			"id" => SORT_ASC
		]
	];

	public $search = [
		"attributes" => [
			"name", "upload_date", "upload_time"
		]
	];

	public $fetcher = 'app\models\doc\File';

	public function getQuery() {
		return File::find();
	}
}