<?php

namespace app\modules\doc\widgets;

use app\core\Widget;
use app\modules\doc\forms\MacroChooseForm;

class MacroChooser extends Widget {

	public function run() {
		return $this->render("MacroChooser", [
			"model" => new MacroChooseForm()
		]);
	}
}