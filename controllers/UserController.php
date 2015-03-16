<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\models\User;

class UserController extends Controller {

	/**
	 * That action will register user in database
	 * and return json response with response or
	 * redirect to main view view message
	 *
	 * @in (POST):
	 *  + model - Serialized client's form
	 *
	 * @out (JSON):
	 *  + message - Response message
	 *  + status - Status (true or false)
	 *
	 * @throws \Exception
	 */
	public function actionRegister() {
		try {
			$form = $this->getFormModel("model", "post", "register");
			if (!$form->validate()) {
				if ($form->hasErrors()) {
					$this->postValidationErrors($form);
				} else {
					$this->error("Произошла неизвестная ошибка при валидации формы");
				}
			}
			$model = $this->getModel($form);
			$model->{"password"} = \Yii::$app->getSecurity()->generatePasswordHash(
				$model->{"password"}
			);
			if (!$model->save()) {
				$this->error("Произошли ошибки во время сохранения данных");
			}
			$this->leave([
				"message" => "Пользователь успешно зарегистрирован"
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * That action will begin user's session
	 *
	 * @in (POST):
	 *  + model - Client's model
	 *
	 * @out (JSON):
	 *  + message - Response message
	 *  + status - Status (true or false)
	 *
	 * @throws \Exception
	 */
	public function actionLogin() {
		try {
			$form = $this->getFormModel("model", "post", "login");
			/** @var User $user */
			$user = User::model()->find()->where("lower(login) = :login", [
				":login" => strtolower($form->{"login"})
			])->one();
			if (!$user) {
				$user = User::model()->find()->where("lower(email) = :email", [
					":email" => strtolower($form->{"login"})
				])->one();
			}
			if (!$user) {
				$this->error("Неверный логин/email или пароль");
			}
			$r = \Yii::$app->getSecurity()->validatePassword(
				$form->{"password"}, $user->{"password"}
			);
			if (!$r) {
				$this->error("Неверный логин/email или пароль");
			}
			if (!\Yii::$app->getUser()->login($user)) {
				$this->error("Произошла ошибка при входе в систему");
			}
			$this->leave([
				"message" => "Пользователь успешно вошел в систему",
				"redirect" => \Yii::$app->getHomeUrl()
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	public function actionLogout() {
		try {
			if (!\Yii::$app->getUser()->getIsGuest()) {
				\Yii::$app->getUser()->logout(true);
			}
			$this->goHome();
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new User($model);
	}
}