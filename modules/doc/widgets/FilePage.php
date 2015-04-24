<?php

namespace app\modules\doc\widgets;

use app\core\ActiveRecord;
use app\core\Widget;
use app\forms\FileForm;
use app\models\File;

class FilePage extends Widget {

	/**
	 * @var ActiveRecord - Table active record instance for
	 * 	table provider to display table with files
	 */
	public $tableActiveRecord = null;

	/**
	 * @var string - Default type of file, which documents
	 * 	should be displayed
	 */
	public $fileType = "document";

	/**
	 * @var string - Text with list of files
	 */
	public $textList = "Список файлов";

	/**
	 * @var string - Text with file change history
	 */
	public $textHistory = "История изменений файла";

	/**
	 * @var string - Text with information about document
	 */
	public $textInfo = "Информация о документе";

	/**
	 * Run widget to return just rendered content
	 * @return string - Just rendered content
	 */
	public function run() {
		return $this->render("FilePage", [
			"self" => $this
		]);
	}
}