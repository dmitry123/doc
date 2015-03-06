<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\models\User;
use yii\base\Exception;

class UserController extends Controller {

	/**
	 * @throws \Exception
	 */
	public function actionLogin() {
		try {

		} catch (Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Override that method to return model for
	 * current controller instance or null
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel() {
		return new User();
	}
}