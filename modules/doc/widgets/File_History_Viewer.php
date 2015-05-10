<?php

namespace app\modules\doc\widgets;

use app\core\Widget;

class File_History_Viewer extends Widget {

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