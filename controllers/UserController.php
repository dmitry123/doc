<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\forms\UserForm;
use app\models\core\Employee;
use app\models\core\User;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\web\UploadedFile;

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
			$model = UserForm::createWithScenario("register");
			if (!$model->load(\Yii::$app->request->bodyParams)) {
				throw new Exception("Can't load registration form");
			}
			if (!$model->validate()) {
				$this->postValidationErrors($model);
			}
			if (User::findOne([ "email" => $model->{"email"} ]) != null) {
				$this->error("Пользователь с таким почтовым ящиком уже зарегистрирован \"{$model->{"email"}}\"");
			}
			$model->{"password"} = \Yii::$app->getSecurity()->generatePasswordHash(
				$model->{"password"}
			);
			print_r($model->getAttributes());
			die;
			if (!$model->getActiveRecord()->save()) {
				if ($model->getActiveRecord()->hasErrors()) {
					$this->postValidationErrors($model->getActiveRecord());
				} else {
					$this->error("Произошли ошибки во время сохранения данных");
				}
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
			$form = $this->requireModel("UserForm", [
				"login", "password"
			], "login");
			/** @var User $user */
			$user = User::find()->where("lower(login) = :login", [
				":login" => strtolower($form->{"login"})
			])->one();
			if (!$user) {
				$user = User::find()->where("lower(email) = :email", [
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
			if (!\Yii::$app->user->login($user)) {
				$this->error("Произошла ошибка при входе в систему");
			}
			$params = [
				"USER_LOGIN" => \Yii::$app->user->identity->{"login"},
				"USER_ID" => \Yii::$app->user->identity->{"id"},
				"USER_EMAIL" => \Yii::$app->user->identity->{"email"}
			];
			$employee = Employee::findOne([
				"user_id" => $user->{"id"}
			]);
			if ($employee != null) {
				$params += [
					"EMPLOYEE_ID" => $employee->{"id"},
					"EMPLOYEE_SURNAME" => $employee->{"surname"},
					"EMPLOYEE_NAME" => $employee->{"name"},
					"EMPLOYEE_PATRONYMIC" => $employee->{"patronymic"}
				];
			}
			foreach ($params as $key => $value) {
				\Yii::$app->getSession()->set($key, $value);
			}
			$this->leave([
				"message" => "Пользователь успешно вошел в систему",
				"redirect" => ""
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * That action will logout user
	 * @throws \Exception
	 */
	public function actionLogout() {
		try {
			if (!\Yii::$app->getUser()->getIsGuest()) {
				\Yii::$app->getUser()->logout(true);
			}
			if (\Yii::$app->getRequest()->getIsAjax()) {
				$this->leave([
					"url" => \Yii::$app->getHomeUrl()
				]);
			} else {
				$this->goHome();
			}
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}
}