<?php

namespace app\modules\doc\widgets;

use app\core\Widget;

class Editor_AboutTemplate_Editor extends Widget {

	public $file = null;

	public function run() {
		return $this->render("Editor_AboutTemplate_Editor", [
		]);
	}
}