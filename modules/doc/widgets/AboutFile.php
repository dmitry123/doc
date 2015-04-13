<?php

namespace app\modules\doc\widgets;

use app\core\Widget;

class AboutFile extends Widget {

	/**
	 * @var int - Document's identification number, which
	 * 	information about u'd like to load
	 */
	public $id = null;

	/**
	 * Prevent auto unique key generation
	 * @see app\core\Widget::init
	 */
	public function init() {
	}

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