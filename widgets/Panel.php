<?php

namespace app\widgets;

use app\core\Widget;

class Panel extends Widget {

	/**
	 * @var string - Panel's title
	 */
	public $title = "";

	/**
	 * @var string|null|Widget - Body content, if null, then content
	 *	will be obtained from print stream
	 */
	public $body = null;

	/**
	 * @var string - Default panel style
	 */
	public $style = "panel panel-default";

	/**
	 * @var string - Extra align class, for example 'text-center', or
	 * 	'text-right' or 'text-left'
	 */
	public $align = "";

	/**
	 * Initialize widget
	 */
	public function init() {
		if ($this->body == null) {
			ob_start();
		}
	}

	/**
	 * Run widget and return just rendered content
	 * @return string - Rendered content
	 */
	public function run() {
		return $this->render("Panel", [
			"content" => $this->body ? $this->body : ob_get_clean(),
			"self" => $this
		]);
	}
}