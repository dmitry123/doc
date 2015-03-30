<?php

namespace app\modules\doc\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\models\Document;
use app\modules\doc\core\FileUploader;

class DocumentController extends Controller {

	/**
	 *
	 */
	public function actionUpload() {
		try {
			if (!isset($_FILES["files"])) {
				$this->error("Не был загружен ни один файл, выберите файлы для загрузки");
			}
			FileUploader::getUploader()->upload($this->getFiles($failed));
			$this->leave([
				"failed" => $failed
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Get array with files, that has been uploaded without
	 * any errors and has tmp file in system, other files
	 * with errors will be [failed] array
	 * @param array $failed - Array with failed files
	 * @param string $key - Name of key in [_FILES] array
	 * @return array - Array with uploaded files
	 */
	public function getFiles(&$failed = [], $key = "files") {
		$result = [];
		$files = $_FILES[$key];
		foreach ($files["error"] as $i => $error) {
			if ($error != UPLOAD_ERR_OK || !$files["tmp_name"][$i]) {
				$failed[] = [
					"name" => $files["name"][$i],
					"type" => $files["type"][$i],
					"error" => $files["error"][$i],
					"size" => $files["size"][$i]
				];
			} else {
				$result[] = [
					"name" => $files["name"][$i],
					"tmp_dir" => $files["tmp_name"][$i],
					"type" => $files["type"][$i],
					"error" => $files["error"][$i],
					"size" => $files["size"][$i]
				];
			}
		}
		return $result;
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new Document();
	}
}