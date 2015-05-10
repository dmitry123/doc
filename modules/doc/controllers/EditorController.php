<?php

namespace app\modules\doc\controllers;

use app\core\Controller;

class EditorController extends Controller {

	public function actionView() {
		if (($file = $this->getQuery("file", null)) != null) {
			return $this->render("view", [
				"file" => $file
			]);
		} else {
			return $this->render("empty");
		}
	}
}