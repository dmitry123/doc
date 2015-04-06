<?php

namespace app\modules\doc\core;

use app\core\EmployeeManager;
use app\models\MimeType;
use app\models\File;
use yii\base\Exception;

class FileUploader {

	/**
	 * Locked constructor
	 */
	private function __construct() {
		/* Locked */
	}

	/**
	 * That method uploads files on server
	 * @param array $files - Multiple file's configurations
	 * @param int $type - Default file's type [\app\fields\FileTypeField]
	 * @see \app\fields\FileTypeField
	 * @throws \Exception
	 */
	public function uploadMultiple(array $files, $type = 1) {
		foreach ($files as $file) {
			$this->upload($file, $type);
		}
	}

	/**
	 * That method uploads file on server
	 * @param array $file - Single file's configuration
	 * @param int $type - Default file's type [\app\fields\FileTypeField]
	 * @see \app\fields\FileTypeField
	 * @throws \Exception
	 */
	public function upload(array $file, $type = 1) {
		if (preg_match("/^(?P<name>.*)\\.(?P<ext>.*)$/i", $file["name"], $matches) === false) {
			throw new Exception("Can't match file pattern to fetch it's filename and extension");
		}
		if (($employee = EmployeeManager::getManager()->getEmployee()) == null) {
			throw new Exception("Only employees can upload files on server");
		}
		$path = \Yii::$app->getSecurity()->generateRandomString();
		try {
			\Yii::$app->getDb()->beginTransaction();
			$mime = new MimeType([
				"mime" => $file["type"],
				"ext" => $matches["ext"]
			]);
			if (!$mime->save()) {
				throw new Exception("File hasn't been uploaded on server, can't save file's extension in database");
			}
			$document = new File([
				"name" => $matches["name"],
				"path" => $path,
				"employee_id" => $employee->{"id"},
				"parent_id" => null,
				"type" => $type,
				"status" => 1,
				"mime_type_id" => $mime->{"id"}
			]);
			if (!$document->save()) {
				throw new Exception("File hasn't been uploaded on server, can't save file info in database");
			}
			if (!@move_uploaded_file($file["tmp_name"], $this->getDirectory($path))) {
				throw new Exception("File hasn't been uploaded on server: \"".error_get_last()["message"]."\"");
			}
			\Yii::$app->getDb()->getTransaction()->commit();
		} catch (\Exception $e) {
			\Yii::$app->getDb()->getTransaction()->rollBack();
			throw $e;
		}
	}

	/**
	 * Get file's directory
	 * @param string|null $file - Set file's name to get it's path
	 * @return string - Directory to files
	 * @throws Exception
	 */
	public function getDirectory($file = null) {
		if (!@file_exists($path = getcwd().\Yii::$app->params["fileUploadDirectory"]) && !@mkdir($path)) {
			throw new Exception("Can't create directory for uploaded files \"$path\"");
		}
		if ($file != null) {
			return $path.$file;
		}
		return $path;
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