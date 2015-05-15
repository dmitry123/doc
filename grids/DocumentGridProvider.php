<?php

namespace app\grids;

use app\core\GridProvider;
use app\models\doc\File;

class DocumentGridProvider extends GridProvider {

	public $columns = [
		"id" => "#",
		"name" => "Название",
		"file_ext_id" => "Расширение",
		"upload_date" => "Дата загрузки",
		"upload_time" => "Время загрузки"
	];

	public $menu = [
		"controls" => [
			"file-open-icon" => [
				"label" => "Открыть файл",
				"icon" => "fa fa-folder-open-o"
			],
            "file-remove-icon" => [
                "label" => "Удалить файл",
                "icon" => "fa fa-trash font-danger",
                "onclick" => "confirmDelete()"
            ],
		],
		"mode" => \app\widgets\ControlMenu::MODE_MENU
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
		return File::find()->where("file_type_id = :file_type_id", [
            ":file_type_id" => "document"
        ]);
	}
}