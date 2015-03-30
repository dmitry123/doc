<?php

namespace app\modules\doc\core;

use app\core\EmployeeManager;
use app\models\Document;
use yii\base\Exception;

class FileUploader {

	const DIRECTORY = "uploads/files";

	/**
	 * Locked constructor
	 */
	private function __construct() {
		/* Locked */
	}

	public function upload(array $files) {
		foreach ($files as $file) {
			if (preg_match("/^(?P<name>.*)\\.(?P<ext>.*)$/i", $file["name"], $matches) === false) {
				throw new Exception("Can't match file pattern to fetch it's filename and extension");
			}
			$path = \Yii::$app->getSecurity()->generateRandomString();
			if (($employee = EmployeeManager::getManager()->getEmployee()) == null) {
				throw new Exception("Only employee can upload files on server");
			}
			$name = $matches["name"];
			$ext = $matches["ext"];
			$document = new Document([
				"name" => $name,
				"path" => $path,
				"employee_id" => $employee->{"id"},
				"parent_id" => null,
				"type" => $file["type"]
			]);
			if (!$document->save()) {
				throw new Exception("File hasn't been uploaded on server, can't save file info in database");
			}
		}
	}

	/**
	 * Get single file uploader instance
	 * @return FileUploader - Instance of file uploader
	 */
	public static function getUploader() {
		if (self::$uploader == null) {
			return self::$uploader = new FileUploader();
		} else {
			return self::$uploader;
		}
	}

	/**
	 * @var FileUploader - single file uploader instance
	 */
	private static $uploader = null;
}