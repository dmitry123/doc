<?php

namespace app\modules\doc\core;

use app\core\AbstractFactory;
use app\core\EmployeeHelper;
use app\filters\AccessFilter;
use app\models\doc\File;
use app\models\doc\FileExt;
use yii\base\Exception;
use yii\base\UserException;

class TemplateFactory extends AbstractFactory {

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
        if (!$file = File::findOne([ "id" => $id ])) {
            throw new Exception("Can't resolve file with \"$id\" identification number ");
        } else if ($file->{"file_type_id"} != "document") {
            throw new UserException("Файл должен иметь тип документа");
        }
        $src = FileManager::getManager()->getDirectory($file->{"path"});
        $path = FileManager::getManager()->getName();
        FileConverter::getHtmlConverter()
            ->convert($src)
            ->wait()
            ->rename(FileManager::getManager()->getDirectory($path));
        $template = new File([
                "path" => $path,
                "employee_id" => EmployeeHelper::getHelper()->getEmployee()->{"id"},
                "file_ext_id" => FileExt::findByExt("html")->{"id"},
                "mime_type" => $file->{"mime_type"},
                "file_status_id" => $file->{"file_status_id"},
                "parent_id" => $file->{"id"},
                "file_type_id" => "template",
            ] + $params + [
                "file_category_id" => null,
                "name" => FileManager::getManager()->getName(),
            ]);
        if (!$template->save()) {
            throw new Exception("File hasn't been uploaded on server, can't save file info in database");
        }
		return $template;
	}

    /**
     * Produce instance of some component via
     * your factory singleton instance
     *
     * @param $module string name of module for
     *    current component
     *
     * @param $id int|string identification number
     *    of your object, which will be produced
     *
     * @param $params array with class parameters
     *    which copies to itself
     *
     * @return mixed instance of something
     */
    public function createEx($module, $id, $params = []) {
        /** @var $behavior AccessFilter */
        $behavior = \Yii::$app->getModule($module)->getBehavior("access");
        if ($behavior->validateModule($module)) {
            return $this->create($id, $params);
        } else {
            return null;
        }
    }
}