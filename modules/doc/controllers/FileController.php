<?php

namespace app\modules\doc\controllers;

use app\core\Controller;
use app\core\EmployeeHelper;
use app\core\MimeTypeMatcher;
use app\models\doc\File;
use app\models\doc\FileExt;
use app\modules\doc\core\FileConverter;
use app\modules\doc\core\FileManager;
use app\widgets\Panel;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HeaderCollection;
use yii\web\HtmlResponseFormatter;
use yii\web\YiiAsset;

class FileController extends Controller {

	/**
	 * Default index action
	 * @throws \Exception
	 */
	public function actionView() {
		try {
			return $this->render("view", [
			]);
		} catch (\Exception $e) {
			return $this->exception($e);
		}
	}

	/**
	 * That action uploads files on server
	 * @see DocumentController::getFiles
	 * @see FileUploader::upload
	 */
	public function actionUpload() {
		try {
			if (!isset($_FILES["files"])) {
				$this->error("Не был загружен ни один файл, выберите файлы для загрузки");
			}
			$errors = [];
			foreach ($this->getFiles($failed) as $file) {
				try {
					FileManager::getManager()->upload($file);
				} catch (\Exception $e) {
					$errors[$file["name"]] = $e->getMessage();
				}
			}
			if (count($errors) > 0) {
				return $this->leave([
					"message" => "Загрузка завершилась с ошибками",
					"errors" => $errors,
					"status" => false,
				]);
			} else {
				return $this->leave([
					"message" => "Загрузка завершилась без ошибок",
					"errors" => $errors
				]);
			}
		} catch (\Exception $e) {
			return $this->exception($e);
		}
	}

    public function actionDownload() {
        try {
            /** @var $file File */
            if (!$file = File::findOne([ "id" => $this->requireQuery("file") ])) {
                throw new Exception("Can't resolve file's identification number");
            } else {
                $path = FileManager::getManager()->getDirectory($file->{"path"});
            }
            if (($ext = $this->getQuery("ext")) != null && $ext != $file->{"file_ext_id"}) {
                /** @var $ext FileExt */
                if (!$ext = FileExt::findOne([ "id" => $ext ])) {
                    throw new Exception("Can't resolve file's extension");
                }
                if (!$cached = File::findCached($ext->{"id"}, $file->{"id"})) {
                    $cached = FileManager::getManager()->cache($file, $ext);;
                }
                $path = FileManager::getManager()->getDirectory($cached->{"path"});
            } else if (!$ext = FileExt::findOne([ "id" => $file->{"file_ext_id"} ])) {
                throw new Exception("Can't resolve file's extension");
            }
            if (!file_exists($path)) {
                throw new UserException("Файл отсутствует на сервере, возможно он был изменен или удален");
            }
            $mimeType = MimeTypeMatcher::match($ext->{"ext"});
            \Yii::$app->getResponse()->setDownloadHeaders($file->{"name"}.".".$ext->{"ext"}, $mimeType)
                ->sendFile($path);
        } catch (\Exception $e) {
            $this->exception($e);
        }
    }

    public function actionDelete() {
        try {
            /** @var $file File */
            if (!$file = File::findOne([ "id" => $this->requirePost("file") ])) {
                throw new Exception("Can't resolve file's identification number");
            }
            $file->{"file_status_id"} = "removed";
            if (!$file->save()) {
                throw new Exception("Can't change file's status to removed");
            }
            return $this->leave([
                "message" => "Файл был успешно удален"
            ]);
        } catch (\Exception $e) {
            return $this->exception($e);
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
	public function getFiles(&$failed, $key = "files") {
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
					"tmp_name" => $files["tmp_name"][$i],
					"type" => $files["type"][$i],
					"error" => $files["error"][$i],
					"size" => $files["size"][$i]
				];
			}
		}
		return $result;
	}
}