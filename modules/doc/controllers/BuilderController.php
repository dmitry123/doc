<?php

namespace app\modules\doc\controllers;

use app\core\Controller;
use app\models\doc\File;
use app\modules\doc\core\FileManager;
use yii\base\Exception;

class BuilderController extends Controller {

	public function actionFile() {
		if (!$file = File::findOne([ "id" => $this->requireQuery("file") ])) {
			throw new Exception("Can't resolve file's identification number (". $this->requireQuery("file") .")");
		}
		return $this->render("file", [
			"file" => $file,
			"content" => iconv("Windows-1251", "UTF-8", file_get_contents(
				FileManager::getManager()->getDirectory($file->{"path"}), FILE_TEXT
			)),
			"macro" => File::findFileMacro($file->{"id"})
		]);
	}

	public function actionForm() {
		if (!$file = File::findOne([ "id" => $this->requireQuery("file") ])) {
			throw new Exception("Can't resolve file's identification number (". $this->requireQuery("file") .")");
		}
		return $this->render("form", [
			"file" => $file,
			"content" => iconv("Windows-1251", "UTF-8", file_get_contents(
				FileManager::getManager()->getDirectory($file->{"path"}), FILE_TEXT
			)),
			"macro" => File::findFileMacro($file->{"id"})
		]);
	}
}