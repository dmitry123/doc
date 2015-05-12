<?php

namespace app\modules\doc\widgets;

use yii\bootstrap\Widget;

class Editor_ControlMenu_Nav extends Widget {

	public $items = [];

	public function run() {
		return $this->render("Editor_ControlMenu_Nav", [
			"items" => $this->items
		]);
	}
}