<?php

namespace app\modules\doc\widgets;

use app\core\Widget;

class BasicActions extends Widget {

	/**
	 * Run widget and return it's just rendered content
	 * @return string - Rendered content
	 */
	public function run() {
		return $this->render("BasicActions", [
			"self" => $this
		]);
	}
}