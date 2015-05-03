<?php

namespace app\modules\admin\controllers;

use app\core\Controller;

class MasterController extends Controller {

	public function actionView() {
		return $this->render("modules", []);
	}
}