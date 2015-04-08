<?php

namespace app\modules\doc\widgets;

use app\core\Widget;

class FileHistory extends Widget {

	/**
	 * Run widget and return it's just rendered content
	 * @return string - Rendered content
	 */
	public function run() {
		return $this->render("FileHistory", [
			"self" => $this
		]);
	}
}