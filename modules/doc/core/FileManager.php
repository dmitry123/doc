<?php

namespace app\modules\doc\core;

use app\core\EmployeeHelper;
use app\core\MimeTypeMatcher;
use app\models\doc\File;
use app\models\doc\FileExt;
use app\models\doc\FileStatus;
use yii\base\Exception;
use yii\db\ActiveRecord;

class FileManager {

	const PATH_LENGTH = 32;

	/**
	 * Get single file uploader instance
     *
	 * @return FileManager instance of file uploader
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
		$path = $this->getName();
		try {
			\Yii::$app->getDb()->beginTransaction();
			if (!($fileStatus = FileStatus::findOne([ "id" => "new" ]))) {
				throw new Exception("Can't resolve file's status \new\" in database");
			}
			if (!$ext = FileExt::findOne([ "ext" => $matches["ext"] ])) {
				$ext = new FileExt([
                    "ext" => $matches["ext"],
                    "file_type_id" => "unknown"
                ]);
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
	 *
	 *
	 * @param $file File instance of file model class, which stores information about current
	 *  file, which should be  prepared and cached for next downloads and registered in database
	 *
	 * @param $ext FileExt|ActiveRecord|static instance of extension class, which stores information
	 *  about new file's extension
	 *
	 * @param $alias string|null name of future document file
	 *
	 * @param $type string name of file type, that should be set
	 *    for database cortege
	 *
	 * @return File instance of new file, which prepared
	 *  for downloads and other manipulations
	 *
	 * @throws Exception
	 */
    public function cache($file, $ext, $alias = null, $type = "cached") {
		if ($alias == null) {
			$alias = FileManager::getManager()->getName();
		}
		$name = FileManager::getManager()->getName();
        $path = FileManager::getManager()->getDirectory($name);
		FileConverter::getDefaultConverter($ext->{"ext"})
			->convert($this->getDirectory($file->{"path"}))
			->wait()
			->rename($path);
        $cached = new File([
            "path" => $name,
            "employee_id" => $file->{"employee_id"},
            "file_ext_id" => $ext->{"id"},
            "mime_type" => MimeTypeMatcher::match($ext->{"ext"}),
            "parent_id" => $file->{"id"},
            "file_status_id" => "new",
            "file_type_id" => $type,
            "file_category_id" => null,
            "name" => $alias,
        ]);
        if (!$cached->save()) {
            throw new Exception("File hasn't been prepared to download, can't register changes in database");
        }
        return $cached;
    }

	/**
	 * Load file's content by it's cortege
	 *
	 * @param $file File active record instance
	 * @return string file's content
	 *
	 * @throws Exception
	 */
	public function load($file) {
		return iconv("Windows-1251", "UTF-8", file_get_contents(
			\app\modules\doc\core\FileManager::getManager()->getDirectory($file->{"path"}), FILE_TEXT
		));
	}

	/**
	 * Generate unique name of saved file on server
	 * @return string name of file
	 */
	public function getName() {
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