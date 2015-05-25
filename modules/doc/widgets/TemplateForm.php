<?php

namespace app\modules\doc\widgets;

use app\models\doc\File;
use app\modules\doc\core\FileWidget;

class TemplateForm extends FileWidget {

	public function run() {
		$list = File::findFileMacro($this->file->{"id"});
		$model = new \yii\base\DynamicModel();
		foreach ($list as $m) {
			$model->defineAttribute($m["id"], $m["value"]);
		}
		$model->defineAttribute("file_id", $this->file->{"id"});
		$model->defineAttribute("name");
		return $this->render("TemplateForm", [
			"model" => $model,
			"file" => $this->file,
			"list" => $list,
		]);
	}
}