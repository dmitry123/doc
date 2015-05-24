<?php

namespace app\modules\doc\controllers;

use app\core\Controller;
use app\models\doc\File;
use app\models\doc\FileMacro;
use app\modules\doc\core\TemplateFactory;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class TemplateController extends Controller {

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

	public function actionRegister() {
		try {
			$template = TemplateFactory::getFactory()->create($this->requirePost("file"), [
				/* Template configuration like category or name */
			]);
			$this->leave([
				"message" => "Шаблон был успешно сгенерирован",
				"file" => $template->{"id"}
			]);
		} catch (Exception $e) {
			$this->exception($e);
		}
	}

	public function actionSave() {
		$t = \Yii::$app->getDb()->beginTransaction();
		try {
			if (!$file = File::findOne([ "id" => $this->requirePost("file") ])) {
				throw new HttpException(404, "Unresolved template identification number (". $this->requirePost("file") .")");
			}
			$prev = FileMacro::find()->where("file_id = :file_id", [
				":file_id" => $file->{"id"}
			])->all();
			$prev = ArrayHelper::map($prev, "path", "id");
			foreach ($this->getPost("items", []) as $item) {
				if (in_array($item["path"], $prev)) {
					array_splice($prev, $item["path"]);
					continue;
				}
				$ar = new FileMacro();
				$ar->setAttributes([
					"macro_id" => $item["id"],
					"file_id" => $file->{"id"},
					"path" => $item["path"],
					"name" => $item["text"]
				], false);
				$ar->save();
			}
			foreach ($prev as $p => $id) {
				FileMacro::deleteAll([ "id" => $id ]);
			}
			$t->commit();
			$this->leave([
				"message" => "Шаблон успешно сохранен"
			]);
		} catch (Exception $e) {
			$t->rollBack();
			$this->exception($e);
		}
	}
}