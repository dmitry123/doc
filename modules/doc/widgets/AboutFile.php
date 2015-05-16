<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileWidget;

class AboutFile extends FileWidget {

	/**
	 * Run widget and return it's just rendered content
	 * @return string - Rendered content
	 */
	public function run() {
		return $this->render("AboutFile", [
			"self" => $this
		]);
	}
}