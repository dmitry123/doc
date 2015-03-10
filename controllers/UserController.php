<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\forms\UserForm;
use app\models\User;
use yii\base\Model;

class UserController extends Controller {

	public function actionRegister() {
		try {
			$model = new UserForm("register");
			$model->attributes = \Yii::$app->getRequest()->post();
			if ($model->validate()) {
				$user = new User($model);
				if (!$user->save(false)) {
					$this->error("Произошли ошибки во время сохранения данных");
				}
			} else if ($model->hasErrors()) {
				$this->postValidationErrors($model);
			}
			$this->leave([
				"message" => "Пользователь успешно зарегистрирован"
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	public function actionLogin() {
		try {
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	public function actionLogout() {
		try {
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model Model - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new User($model);
	}
}