<?php

namespace app\modules\doc\widgets;

use app\models\File;
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
			"class" => "glyphicon glyphicon-cog",
			"tooltip" => "Настроить файл"
		],
		"template-create-icon" => [
			"class" => "glyphicon glyphicon-list-alt",
			"tooltip" => "Создать шаблон"
		],
		"file-lock-icon" => [
			"class" => "glyphicon glyphicon-lock",
			"tooltip" => "Заблокировать файл"
		]
	];

	public $tableClass = "table table-striped table-hover";
	public $orderBy = "upload_date";
	public $controlsWidth = 150;

	public function init() {
		$this->provider = File::model()->getMainTableProvider($this->fileType);
		parent::init();
	}
}