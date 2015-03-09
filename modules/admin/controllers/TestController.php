<?php

namespace app\modules\admin\controllers;

use app\core\ActiveRecord;
use app\core\Controller;

class TestController extends Controller {

	public function actionView() {
		print $this->render("view");
	}

	/**
	 * Override that method to return model for
	 * current controller instance or null
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel() {
		return null;
	}
}