<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileWidget;

class FileExporter extends FileWidget {

	public function run() {
		return $this->render("FileExporter", [
			"file" => $this->file,
			"ext" => $this->file->findExt()
		]);
	}
}