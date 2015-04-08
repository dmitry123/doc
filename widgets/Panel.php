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
	public $panelClass = "panel panel-default";

	/**
	 * @var string - Style of panel's heading, by
	 * 	default it uses row, cuz it has hidden glyphicons
	 * 	in [col-xs-12] classes, which needs fixes height
	 */
	public $headingClass = "panel-heading row";

	/**
	 * @var string - Style of panel's body, you can
	 * 	add [no-padding] style to remove panel's body padding
	 */
	public $bodyClass = "panel-body";

	/**
	 * @var bool - Shall panel has update button
	 */
	public $update = true;

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