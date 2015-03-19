<?php

use yii\db\Migration;

class m150318_072311_user_admin extends Migration {

	public function safeUp() {
		$hash = Yii::$app->getSecurity()->generatePasswordHash(
			Yii::$app->params["adminPassword"]
		);
		$user = new \app\models\User([
			"login" => Yii::$app->params["adminLogin"],
			"password" => $hash,
			"email" => Yii::$app->params["adminEmail"]
		]);
		if (!$user->save(true)) {
			throw new \yii\base\ErrorException("Can't register admin user in database");
		}
		/* PhoneType - Mobile (@see app\fields\PhoneTypeField) */
		$phone = new \app\models\Phone([
			"phone" => Yii::$app->params["adminPhone"],
			"type" => 1
		]);
		if (!$phone->save(true)) {
			throw new \yii\base\ErrorException("Can't register phone for administrator in database");
		}
		$role = new \app\models\Role([
			"id" => "admin",
			"description" => "Может администрировать систему",
			"name" => "Администратор",
		]);
		if (!$role->save(true)) {
			throw new \yii\base\ErrorException("Can't register administrator role");
		}
		$employee = new \app\models\Employee([
			"surname" => Yii::$app->params["adminSurname"],
			"name" => Yii::$app->params["adminName"],
			"patronymic" => Yii::$app->params["adminPatronymic"],
			"role_id" => $role->{"id"},
			"user_id" => $user->{"id"},
			"department_id" => null,
			"phone_id" => $phone->{"id"}
		]);
		if (!$employee->save(true)) {
			throw new \yii\base\ErrorException("Can't register employee for administrator in database");
		}
	}

	public function safeDown() {
		$login = Yii::$app->params["adminLogin"];
		$user = \app\models\User::findOne([
			"login" => $login
		]);
		if (!$user) {
			throw new \yii\base\ErrorException("Can't resolve default admin login \"{$login}\"");
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
