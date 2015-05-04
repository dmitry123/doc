<?php

namespace app\modules\doc\controllers;

use app\core\Controller;

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
}