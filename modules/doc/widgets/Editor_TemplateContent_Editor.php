<?php

namespace app\modules\doc\widgets;

use app\core\Widget;
use yii\base\Exception;

class Editor_TemplateContent_Editor extends Widget {

	public $file = null;

	public function run() {
		if (empty($this->file)) {
			throw new Exception("File's identification number mustn't be empty");
		}
		return $this->render("Editor_TemplateContent_Editor", [
			"content" => "WoHoo"
		]);
	}
}