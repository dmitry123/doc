<?php

namespace app\widgets;

use app\core\Widget;

class Navigation extends Widget {
	
	public function run() {
		return $this->render("Navigation");
	}
}