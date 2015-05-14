<?php

namespace app\components;

use app\models\core\Employee;
use app\models\core\Privilege;

class User extends \yii\web\User {

	public function can($permissionName, $params = [], $allowCaching = true) {
		if ($allowCaching && isset($this->_access[$permissionName])) {
			return $this->_access[$permissionName];
		}
		if (!$employee = Employee::findOne([ "user_id" => $this->getId() ])) {
			return false;
		}
		$access = Privilege::checkAccess($employee->id, $permissionName);
		if ($allowCaching && empty($params)) {
			return $this->_access[$permissionName] = $access;
		} else {
			return $access;
		}
	}

	private $_access = [];
}