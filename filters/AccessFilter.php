<?php

namespace app\filters;

use app\core\Module;
use app\models\Employee;
use app\models\Privilege;
use app\models\Role;
use yii\base\ActionFilter;
use yii\base\Exception;

class AccessFilter extends ActionFilter {

	public $actions = [];
	public $roles = [];
	public $privileges = [];

	public function beforeAction($action) {
		if (empty($this->actions) && empty($this->roles) && empty($this->privileges)) {
			return true;
		}
		$result = $this->validateAction($action->id) && $this->validateRoles($this->roles) &&
			$this->validatePrivileges($this->privileges);
		return $this->accessDenied($result);
	}

	public function getUser() {
		if (!\Yii::$app->getUser()->getIsGuest()) {
			return $this->_user = \Yii::$app->getUser()->getIdentity();
		} else {
			return $this->accessDenied(false);
		}
	}

	public function getEmployee() {
		$this->_employee = Employee::model()->findOne([
			"user_id" => $this->getUser()->getId(),
			"is_validated" => 1
		]);
		if ($this->_employee) {
			return $this->_employee;
		} else {
			return $this->accessDenied(false);
		}
	}

	public function validateModule($module) {
		if (is_string($module) && !$module = \Yii::$app->getModule($module)) {
			return false;
		}
		if (!$module instanceof Module) {
			throw new Exception("Module must be an instance of [app\\core\\Module] class");
		}
		return $this->validateRoles($module->roles) &&
			$this->validatePrivileges($module->privileges);
	}

	public function validateAction($id) {
		if (!isset($this->actions[$id]) || $this->actions[$id]) {
			return true;
		} else {
			$action = $this->actions[$id];
		}
		if (isset($action["roles"])) {
			$roles = $action["roles"];
		} else {
			$roles = null;
		}
		if (isset($action["privileges"])) {
			$privileges = $action["privileges"];
		} else {
			$privileges = null;
		}
		if (empty($roles) && empty($privileges)) {
			return true;
		} else {
			return $this->validateRoles($roles) &&
				$this->validatePrivileges($privileges);
		}
	}

	public function validateRoles($roles) {
		if (empty($roles)) {
			return true;
		} else {
			return Role::checkAccess($this->getEmployee()->{"id"}, $roles);
		}
	}

	public function validatePrivileges($privileges) {
		if (empty($privileges)) {
			return true;
		} else {
			return Privilege::checkAccess($this->getEmployee()->{"id"}, $privileges);
		}
	}

	private function accessDenied($result) {
		if (!$result) {
			\Yii::$app->controller->goHome();
		}
		return $result;
	}

	public function afterAction($action, $result) {
		return $result;
	}

	private $_employee;
	private $_user;
}