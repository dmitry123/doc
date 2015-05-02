<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\models\Employee;
use yii\base\Exception;

class EmployeeController extends Controller {

	/**
	 * Display default employee page to register. If current user is
	 * guest or it already has employee, then it will be redirected
	 * to default home page
	 */
	public function actionIndex() {
//		if (\Yii::$app->getUser()->getIsGuest()) {
//			return $this->goHome();
//		}
//		$employee = Employee::model()->findOne([
//			"user_id" => \Yii::$app->getUser()->getIdentity()->{"id"}
//		]);
//		if (\Yii::$app->getSession()->has("EMPLOYEE_ID")) {
//			return $this->render("index", [
//				"employee" => $employee
//			]);
//		} else {
//			return $this->render("register", []);
//		}
	}

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

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new Employee($model);
	}
}