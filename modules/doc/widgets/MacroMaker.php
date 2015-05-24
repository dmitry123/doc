<?php

namespace app\modules\doc\widgets;

use app\core\Widget;
use app\modules\doc\forms\MacroForm;

class MacroMaker extends Widget {

	/**
	 * @var bool should macro be static or dynamic
	 */
	public $static = "true";

	/**
	 * @var int identification number of file, to which
	 * 	new macro should be attached
	 */
	public $file = null;

    public function run() {
		if (empty($this->file)) {
			$this->file = \Yii::$app->getRequest()->getQueryParam("file");
		}
		if ($this->static == "true") {
			$this->static = 1;
		} else {
			$this->static = 0;
		}
        return $this->render("MacroMaker", [
            "model" => new MacroForm([
				"is_static" => $this->static,
				"file_id" => $this->file
			])
        ]);
    }
}