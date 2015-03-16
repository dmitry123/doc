<?php

namespace app\modules\admin\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;

class TableController extends Controller {

	public final function actionIndex() {
		try {
			print $this->render("index", [
				"self" => $this
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
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