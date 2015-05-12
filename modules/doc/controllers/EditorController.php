<?php

namespace app\modules\doc\controllers;

use app\core\Controller;
use app\models\doc\File;
use app\modules\doc\core\FileUploader;
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

	public function actionLoad() {
		try {
			if (!$file = File::findOne([ "id" => $this->requireQuery("file") ])) {
				throw new Exception("Can't resolve file with \"". $this->requireQuery("file") ."\" identification number");
			} else if ($file->{"file_type_id"} != "template") {
				throw new Exception("Можно редактировать только шаблоны файлов");
			}
			$content = iconv("Windows-1251", "UTF-8", file_get_contents(
				FileUploader::getUploader()->getDirectory($file->{"path"}), FILE_TEXT
			));
			print preg_replace('~(\<br.*\>)+~', "", $content);
		} catch (Exception $e) {
			$this->exception($e);
		}
	}
}