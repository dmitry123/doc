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
			"table-template-icon" => [
				"label" => "Создать шаблон",
				"icon" => "fa fa-copy"
			],
			/* "table-edit-icon" => [
				"label" => "Редактировать",
				"icon" => "glyphicon glyphicon-pencil"
			],
			"table-remove-icon" => [
				"label" => "Удалить",
				"icon" => "glyphicon glyphicon-remove"
			] */
		],
		"mode" => \app\widgets\ControlMenu::MODE_ICON
	];

	public $footer = [
		"withPagination" => true,
		"withLimit" => true,
		"withSearch" => false,
	];

	public $pagination = [
		"pageSize" => 100,
		"page" => 0
	];

	public $sort = [
		"attributes" => [
			"id", "name", "file_ext_id", "upload_date", "upload_time"
		],
		"orderBy" => [
			"upload_date" => SORT_DESC,
			"upload_time" => SORT_DESC
		]
	];

	public $search = [
		"attributes" => [
			"name", "upload_date", "upload_time"
		]
	];

	public $limits = [
		100, 200, 300
	];

	public $fetcher = 'app\models\doc\File';

	public function getQuery() {
		return File::find();
	}
}