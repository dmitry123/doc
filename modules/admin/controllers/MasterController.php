<?php

namespace app\modules\admin\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;

class MasterController extends Controller {

	public function actionView() {
		return $this->render("modules", []);
	}
}