<?php

namespace app\modules\doc\controllers;

use app\core\Controller;
use app\models\doc\File;
use app\models\doc\FileExt;
use app\modules\doc\core\FileCompiler;
use app\modules\doc\core\FileManager;
use yii\base\DynamicModel;
use yii\base\Exception;

class BuilderController extends Controller {

	public function actionFile() {
		if (!$file = File::findOne([ "id" => $this->requireQuery("file") ])) {
			throw new Exception("Can't resolve file's identification number (". $this->requireQuery("file") .")");
		}
		return $this->render("file", [
			"file" => $file
		]);
	}

	public function actionForm() {
		if (!$file = File::findOne([ "id" => $this->requireQuery("file") ])) {
			throw new Exception("Can't resolve file's identification number (". $this->requireQuery("file") .")");
		}
		return $this->render("form", [
			"file" => $file
		]);
	}

	public function actionBuild() {
		try {
			$model = new DynamicModel();
			$form = \Yii::$app->getRequest()->getBodyParam("DynamicModel");
			foreach ($form as $key => $value) {
				$model->defineAttribute($key, $value);
				$model->addRule($key, "required");
			}
			if (!$model->validate()) {
				$this->postErrors($model);
			}
			/* @var $file File */
			if (!$file = File::findOne([ "id" => $model->{"file_id"} ])) {
				throw new Exception("Can't resolve file ({$model->{"file_id"}}) identification number");
			} else {
				$compiler = new FileCompiler($file);
			}
			$content = $compiler->compile($model);
			$clone = FileManager::getManager()->cache(
				$file, FileExt::findByExt("html"), $model->{"name"}, "document"
			);
			$dir = FileManager::getManager()->getDirectory($clone->{"path"}, true);
			$handle = fopen($dir, "wb+");
			$content = preg_replace('/<meta[^>.]*>/', "", $content);
			fwrite($handle, $content, strlen($content));
			fclose($handle);
			$this->leave([
				"message" => "Документ создан"
			]);
		} catch (Exception $e) {
			$this->exception($e);
		}
	}
}