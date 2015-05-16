<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileWidget;

class FileHistory extends FileWidget {

	/**
	 * Run widget and return it's just rendered content
	 * @return string - Rendered content
	 */
	public function run() {
		return $this->render("File_History_Viewer", [
			"self" => $this
		]);
	}
}