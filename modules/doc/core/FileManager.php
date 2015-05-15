<?php

namespace app\modules\doc\core;

use app\core\EmployeeHelper;
use app\models\doc\File;
use app\models\doc\FileExt;
use app\models\doc\FileStatus;
use yii\base\Exception;

class FileManager {

	const PATH_LENGTH = 32;

	/**
	 * Get single file uploader instance
	 * @return FileManager - Instance of file uploader
	 */
	public static function getManager() {
		if (self::$uploader == null) {
			return self::$uploader = new FileManager();
		} else {
			return self::$uploader;
		}
	}

	/**
	 * That method uploads files on server
	 *
	 * @param $files array with multiple file's configurations
	 * @param $config array with file's table attributes
	 *
	 * @throws \Exception
	 */
	public function uploadMultiple(array $files, $config = []) {
		foreach ($files as $file) {
			$this->upload($file, $config);
		}
	}

	/**
	 * That method uploads file on server
	 *
	 * @param $file array wth file's configuration
	 * @param $config array with file's table attributes
	 *
	 * @throws \Exception
	 */
	public function upload(array $file, $config = []) {
		if (preg_match("/^(?P<name>.*)\\.(?P<ext>.*)$/i", $file["name"], $matches) === false) {
			throw new Exception("Can't match file pattern to fetch it's filename and extension");
		}
		if (($employee = EmployeeHelper::getHelper()->getEmployee()) == null) {
			throw new Exception("Only employees can upload files on server");
		}
		$path = $this->generateName();
		try {
			\Yii::$app->getDb()->beginTransaction();
			if (!($fileStatus = FileStatus::findOne([ "id" => "new" ]))) {
				throw new Exception("Can't resolve file's status \new\" in database");
			}
			if (!$ext = FileExt::findOne([ "ext" => $matches["ext"] ])) {
				$ext = new FileExt([ "ext" => $matches["ext"] ]);
				if (!$ext->save()) {
					throw new Exception("File hasn't been uploaded on server, can't save file's extension in database");
				}
			}
			$document = new File([
					"name" => $matches["name"],
					"path" => $path,
					"employee_id" => $employee->{"id"},
					"mime_type" => $file["type"],
					"file_status_id" => $fileStatus->{"id"},
					"file_ext_id" => $ext->{"id"}
				] + $config + [
					"file_category_id" => null,
					"parent_id" => null,
					"file_type_id" => "document",
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
     * @param $name string
     * @param bool $ready
     * @throws Exception
     */
    public function remove($name, $ready = false) {
        if (!$ready) {
            $name = $this->getDirectory($name);
        }
        if (!@unlink($name)) {
            throw new Exception("Can't remove file from filesystem: \"". error_get_last()["message"] ."\"");
        }
    }

	/**
	 * Generate unique name of saved file on server
	 * @return string name of file
	 */
	public function generateName() {
		return \Yii::$app->getSecurity()->generateRandomString(static::PATH_LENGTH);
	}

	/**
	 * Get file's directory
	 * @param string|null $file - Set file's name to get it's path
	 * @param $absolute bool should path be absolute or relative
	 * @return string - Directory to files
	 * @throws Exception
	 */
	public function getDirectory($file = null, $absolute = true) {
		if ($this->_path != null) {
			if ($absolute) {
				$path = $this->_path;
			} else {
				$path = substr($this->_path, strlen(getcwd()) + 1);
			}
			if ($file != null) {
				return $path.$file;
			} else {
				return $path;
			}
		} else {
			chdir("..");
		}
		if (!@file_exists($path = getcwd().\Yii::$app->params["fileUploadDirectory"]) && !@mkdir($path)) {
			throw new Exception("Can't create directory for uploaded files \"$path\"");
		} else {
			$this->_path = $path;
		}
		if ($absolute) {
			$path = $this->_path;
		} else {
			$path = substr($this->_path, strlen(getcwd()) + 1);
		}
		if ($file != null) {
			return $path.$file;
		} else {
			return $path;
		}
	}

	private $_path = null;

	/**
	 * Locked constructor
	 */
	private function __construct() {
		/* Locked */
	}

	/**
	 * @var FileManager - single file uploader instance
	 */
	private static $uploader = null;
}