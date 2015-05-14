<?php

namespace app\modules\doc\core;

use app\components\AbstractFactory;
use app\components\EmployeeHelper;
use app\components\UniqueGenerator;
use app\models\doc\File;
use Unoconv\Unoconv;
use yii\base\ErrorException;
use yii\base\Exception;

class TemplateFactory extends AbstractFactory {

	const EXT = "html";

	/**
	 * Produce instance of some component via
	 * your factory singleton instance
	 *
	 * @param $id int|string identification number
	 *    of your object, which will be produced
	 *
	 * @param $params array with class parameters
	 *    which copies to itself
	 *
	 * @return mixed instance of something
	 *
	 * @throws \yii\db\Exception
	 * @throws \Exception
	 */
	public function create($id, $params = []) {
		$lock = \Yii::$app->getDb()->beginTransaction();
		try {
			if (!$file = File::findOne([ "id" => $id ])) {
				throw new Exception("Can't resolve file with \"$id\" identification number ");
			} else if ($file->{"file_type_id"} != "document") {
				throw new ErrorException("Файл должен иметь тип документа");
			}
			$src = FileUploader::getUploader()->getDirectory($file->{"path"});
			$path = FileUploader::getUploader()->generateName();
			$this->castToHtml($src);
			while (!file_exists($src.".".static::EXT)) {
				sleep(1);
			}
			if (!@rename($src.".".static::EXT, FileUploader::getUploader()->getDirectory($path))) {
				throw new Exception("Can't rename just generated template file \"". error_get_last()["message"] ."\"");
			}
			$template = new File([
					"path" => $path,
					"employee_id" => EmployeeHelper::getHelper()->getEmployee()->{"id"},
					"file_ext_id" => $file->{"file_ext_id"},
					"mime_type" => $file->{"mime_type"},
					"file_status_id" => $file->{"file_status_id"},
					"parent_id" => $file->{"id"},
					"file_type_id" => "template",
				] + $params + [
					"file_category_id" => null,
					"name" => FileUploader::getUploader()->generateName(),
				]);
			if (!$template->save()) {
				throw new Exception("File hasn't been uploaded on server, can't save file info in database");
			}
			$lock->commit();
		} catch (Exception $e) {
			$lock->rollBack();
			throw $e;
		}
		return $template;
	}

	private function castToHtml($src) {
		if (substr(php_uname(), 0, 7) == "Windows") {
			$py = "start python.exe";
		} else {
			$py = ".\\python";
		}
		$cmd = "$py vendor/unoconv/unoconv.py -f ".static::EXT." $src";
		$msg = system("$cmd", $r);
		if ($r !== 0) {
			throw new Exception("Converter returned code \"$r\" with error message \"$msg\" while executing command \"$cmd\"");
		}
		sleep(1);
	}
}