<?php

namespace app\modules\doc\widgets;

use app\components\Widget;

class Plantation extends Widget {

	public function run() {
		return $this->render("Plantation", [
			"self" => $this
		]);
	}
}