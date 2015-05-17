<?php

namespace app\modules\doc\controllers;

use app\core\Controller;
use app\core\PostgreSQL;
use app\models\doc\File;
use app\modules\doc\core\FileManager;
use yii\base\Exception;

class EditorController extends Controller {

	public function actionView() {
		if (($file = $this->getQuery("file", null)) != null) {
			if (!$file = File::findOne([ "id" => $file ])) {
				throw new Exception("Can't resolve file with \"$file\" identification number");
			} else if ($file->{"file_type_id"} != "template") {
				throw new Exception("Можно редактировать только шаблоны файлов");
			}
			return $this->render("view", [
				"file" => $file->{"id"},
			]);
		} else {
			return $this->render("empty");
		}
	}
}