<?php

namespace app\widgets;

use app\core\Widget;
use app\models\Employee;
use app\models\Role;

class Navigation extends Widget {
	
	public function run() {
		$identity = \Yii::$app->getUser()->getIdentity();
		$employee = Employee::findOne([
			"user_id" => $identity->{"id"}
		]);
		if ($employee != null) {
			$admin = Role::checkEmployeeRoles($employee->{"id"}, "admin");
		} else {
			$admin = false;
		}
		return $this->render("Navigation", [
			"admin" => $admin
		]);
	}
}