<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileWidget;

class Editor_AboutTemplate_Editor extends FileWidget {

	public function run() {
		return $this->render("Editor_AboutTemplate_Editor", [
		]);
	}
}