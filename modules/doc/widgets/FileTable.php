<?php

namespace app\modules\doc\widgets;

use app\models\doc\File;
use app\widgets\Table;

class FileTable extends Table {

	/**
	 * @var string - Identification value of file type, which
	 * 	files should be displayed
	 */
	public $fileType = "document";

	public $header = [
		"file_type_id" => [
			"label" => "Тип файла",
			"style" => "width: 125px"
		],
		"name" => [
			"label" => "Наименование"
		],
		"upload_date" => [
			"label" => "Дата загрузки"
		]
	];

	public $controls =  [
		"file-configure-icon" => [
			"label" => "Настроить файл",
			"icon" => "glyphicon glyphicon-cog",
		],
		"template-create-icon" => [
			"label" => "Создать шаблон",
			"icon" => "glyphicon glyphicon-list-alt",
		],
		"file-lock-icon" => [
			"label" => "Заблокировать файл",
			"icon" => "glyphicon glyphicon-lock",
		]
	];

	public $tableClass = "table table-striped table-hover";
	public $orderBy = "upload_date desc";
	public $controlsWidth = 150;

	public function init() {
		$this->provider = File::getMainTableProvider($this->fileType);
		parent::init();
	}
}