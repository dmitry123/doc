<?php

namespace app\modules\security\controllers;

use app\core\Controller;

class RoleController extends Controller {

	public function actionList() {
		return $this->render("list", []);
	}
}