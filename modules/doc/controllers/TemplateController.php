<?php

namespace app\modules\doc\controllers;

use app\core\Controller;
use app\modules\doc\core\TemplateFactory;
use yii\base\Exception;

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

			]);
			$this->leave([
				"message" => "Шаблон был успешно сгенерирован",
				"file" => $template->{"id"}
			]);
		} catch (Exception $e) {
			return $this->exception($e);
		}
	}
}