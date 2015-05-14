<?php

namespace app\controllers;

use app\components\ActiveRecord;
use app\components\Controller;
use app\components\FormModel;
use app\models\Employee;
use yii\base\Exception;

class EmployeeController extends Controller {

	/**
	 * Register employee in database
	 * @throws \Exception
	 */
	public function actionRegister() {
		try {
		} catch (Exception $e) {
			$this->exception($e);
		}
	}
}