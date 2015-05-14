<?php

namespace app\modules\plantation\controllers;

use app\components\Controller;

class MasterController extends Controller {

	/**
	 * Define behaviors for admin module
	 * @return array - Array with configurations
	 */
	public function behaviors() {
		return parent::behaviors() + [
			"access" => [
				"class" => "app\\components\\filters\\AccessFilter",
				"roles" => [ "super", "admin" ]
			]
		];
	}

	public function actionView() {
		return $this->render("view", [
			"self" => $this
		]);
	}
}