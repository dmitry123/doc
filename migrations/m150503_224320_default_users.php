<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_224320_default_users extends Migration
{
	public function safeUp() {
		if (isset(Yii::$app->params["defaultRoles"])) {
			$roles = Yii::$app->params["defaultRoles"];
		} else {
			$roles = [];
		}
		foreach ($roles as $id => $role) {
			(new \app\models\Role([
				"id" => $id,
				"description" => $role["description"],
				"name" => $role["name"]
			]))->save();
		}
		if (isset(Yii::$app->params["defaultUsers"])) {
			$users = Yii::$app->params["defaultUsers"];
		} else {
			$users = [];
		}
		foreach ($users as $login => $user) {
			\app\core\UserHelper::registerUser($login, $user);
		}
	}

	public function safeDown() {
		if (isset(Yii::$app->params["defaultUsers"])) {
			$users = Yii::$app->params["defaultUsers"];
		} else {
			$users = [];
		}
		foreach ($users as $login => $user) {
			\app\core\UserHelper::deleteUser($login, $user);
		}
		if (isset(Yii::$app->params["defaultRoles"])) {
			$roles = Yii::$app->params["defaultRoles"];
		} else {
			$roles = [];
		}
		foreach ($roles as $id => $role) {
			\app\models\Role::deleteAll([
				"id" => $id
			]);
		}
	}
}
