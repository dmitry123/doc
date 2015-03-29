<?php

namespace app\modules\doc\widgets;

use app\core\Widget;

class DocumentHistory extends Widget {

	/**
	 * Run widget and return it's just rendered content
	 * @return string - Rendered content
	 */
	public function run() {
		return $this->render("DocumentHistory", [
			"self" => $this
		]);
	}
}