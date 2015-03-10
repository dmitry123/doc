<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\models\User;
use yii\base\Exception;
use yii\base\Model;

class LoginController extends Controller {

	public $layout = "block";

	/**
	 * Default user action, will show login and register forms
	 * @throws \Exception
	 */
	public function actionIndex() {
		try {
			print $this->render("index");
		} catch (Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * @throws \Exception
	 */
	public function actionLogin() {
		try {
			print "123";
		} catch (Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model Model - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new User();
	}
}