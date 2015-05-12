<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileWidget;

class Editor_Template_Builder extends FileWidget {

	public function run() {
		return $this->render("Editor_Template_Builder", [
			"file" => $this->file
		]);
	}
}