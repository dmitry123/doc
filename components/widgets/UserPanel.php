<?php

namespace app\components\widgets;

use app\components\Widget;
use app\models\Employee;
use Yii;

class UserPanel extends Widget {

	public function run() {
		$user = Yii::$app->getUser()->getIdentity();
		$employee = Employee::find()->where("id = :user_id", [
			":user_id" => $user->{"id"}
		])->one();
		return $this->render("UserPanel", [
			"self" => $this,
			"employee" => $employee,
			"user" => $user
		]);
	}
}