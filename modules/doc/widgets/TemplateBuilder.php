<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileWidget;

class TemplateBuilder extends FileWidget {

	public function run() {
		return $this->render("TemplateBuilder", [
			"file" => $this->file
		]);
	}
}