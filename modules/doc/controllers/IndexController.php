<?php

namespace app\modules\doc\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use yii\base\Exception;

class IndexController extends Controller {

	/**
	 * Default index action
	 * @throws \Exception
	 */
	public function actionIndex() {
		try {
			return $this->render("index", [
			]);
		} catch (Exception $e) {
			$this->exception($e);
		}
	}

	public function actionNastya() {
		return $this->render("nastya");
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return null;
	}
}