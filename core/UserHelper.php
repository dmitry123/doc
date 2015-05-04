<?php

namespace app\core;

use app\models\core\Employee;
use app\models\core\Phone;
use app\models\core\Role;
use app\models\SecurityKey;
use yii\base\Object;

class UserHelper extends Object {

	public static function registerUser($login, $parameters) {
		$hash = \Yii::$app->getSecurity()->generatePasswordHash(
			$parameters["password"]
		);
		$security = new SecurityKey([
			"key" => \Yii::$app->getSecurity()->generateRandomString(128)
		]);
		if (!$security->save(true)) {
			throw new \yii\base\Exception("Can't register security key for user in database");
		}
		$user = new \app\models\core\User([
			"login" => $login,
			"password" => $hash,
			"email" => $parameters["email"],
			"security_key_id" => $security->{"id"}
		]);
		if (!$user->save(true)) {
			throw new \yii\base\Exception("Can't register user in database");
		}
		if (!$phone = Phone::registerHelper($parameters["phone"])) {
			throw new \yii\base\Exception("Can't register phone in database");
		}
		$role = Role::findOne([
			"id" => $parameters["role"]
		]);
		if (!$role) {
			throw new \yii\base\Exception("Can't resolve default role \"{$parameters["role"]}\" for user, you should declare it in configuration in \"defaultRoles\" array");
		}
		$employee = new Employee([
			"surname" => $parameters["surname"],
			"name" => $parameters["name"],
			"patronymic" => $parameters["patronymic"],
			"role_id" => $role->{"id"},
			"user_id" => $user->{"id"},
			"department_id" => null,
			"phone_id" => $phone->{"id"},
			"is_validated" => true
		]);
		if (!$employee->save(true)) {
			throw new \yii\base\Exception("Can't register employee for administrator in database");
		}
	}

	public static function deleteUser($login) {
		print "|$login|";
		if (($user = \app\models\core\User::findByLogin($login)) == null) {
			throw new \yii\base\Exception("Can't resolve login \"{$login}\" in database");
		}
		$employee = Employee::findOne([
			"user_id" => $user->{"id"}
		]);
		if (!$employee) {
			throw new \yii\base\Exception("Can't resolve employee for user \"{$login}\"");
		}
		Employee::deleteAll([
			"user_id" => $user->{"id"}
		]);
		if ($employee->{"phone_id"} != null) {
			Phone::deleteAll([
				"id" => $employee->{"phone_id"}
			]);
		}
		\app\models\core\User::deleteAll([
			"id" => $user->{"id"}
		]);
		Role::deleteAll([
			"id" => $employee->{"role_id"}
		]);
	}
}