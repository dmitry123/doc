<?php

namespace app\widgets;

use app\core\Widget;

class Form2 extends Widget {

	public $form = "";

	public function init() {
		ob_start();
	}

	public function run() {
		return $this->render("Form2", [
			"content" => ob_get_clean()
		]);
	}
}