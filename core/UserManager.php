<?php

namespace app\core;

use yii\base\Object;

class UserManager extends Object {

	public static function registerUser($login, $parameters) {
		$hash = \Yii::$app->getSecurity()->generatePasswordHash(
			$parameters["password"]
		);
		$user = new \app\models\User([
			"login" => $login,
			"password" => $hash,
			"email" => $parameters["email"]
		]);
		if (!$user->save(true)) {
			throw new \yii\base\ErrorException("Can't register user in database");
		}
		/* PhoneType - Mobile (@see app\fields\PhoneTypeField) */
		$phone = new \app\models\Phone([
			"phone" => $parameters["phone"],
			"type" => 1
		]);
		if (!$phone->save(true)) {
			throw new \yii\base\ErrorException("Can't register phone in database");
		}
		$role = \app\models\Role::findOne([
			"id" => $parameters["role"]
		]);
		if (!$role) {
			throw new \yii\base\ErrorException("Can't resolve default role \"{$parameters["role"]}\" for user, you should declare it in configuration in \"defaultRoles\" array");
		}
		$employee = new \app\models\Employee([
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
			throw new \yii\base\ErrorException("Can't register employee for administrator in database");
		}
	}

	public static function deleteUser($login) {
		print "|$login|";
		if (($user = \app\models\User::findByLogin($login)) == null) {
			throw new \yii\base\ErrorException("Can't resolve login \"{$login}\" in database");
		}
		$employee = \app\models\Employee::findOne([
			"user_id" => $user->{"id"}
		]);
		if (!$employee) {
			throw new \yii\base\ErrorException("Can't resolve employee for user \"{$login}\"");
		}
		\app\models\Employee::deleteAll([
			"user_id" => $user->{"id"}
		]);
		if ($employee->{"phone_id"} != null) {
			\app\models\Phone::deleteAll([
				"id" => $employee->{"phone_id"}
			]);
		}
		\app\models\User::deleteAll([
			"id" => $user->{"id"}
		]);
		\app\models\Role::deleteAll([
			"id" => $employee->{"role_id"}
		]);
	}
}