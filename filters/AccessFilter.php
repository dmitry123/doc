<?php

namespace app\filters;

use app\models\Employee;
use app\models\Privilege;
use app\models\Role;
use yii\base\Action;
use yii\base\ActionFilter;

class AccessFilter extends ActionFilter {

	public $actions = [];
	public $roles = [];
	public $privileges = [];

	/**
	 * This method is invoked right before an action is to be executed (after all possible filters), you may override
	 * 	this method to do last-minute preparation for the action
	 * @param Action $action - The action to be executed.
	 * @return boolean - Whether the action should continue to be executed.
	 */
	public function beforeAction($action) {
		if (empty($this->actions) && empty($this->roles) && empty($this->privileges)) {
			return true;
		}
		if (!\Yii::$app->getUser()->getIsGuest()) {
			$this->_user = \Yii::$app->getUser()->getIdentity();
		} else {
			return $this->accessDenied(false);
		}
		$this->_employee = Employee::model()->findOne([
			"user_id" => $this->_user->getId(),
			"is_validated" => 1
		]);
		if (!$this->_employee) {
			return $this->accessDenied(false);
		}
		$result = $this->validateAction($action->id) && $this->validateRoles($this->roles) &&
			$this->validatePrivileges($this->privileges);
		return $this->accessDenied($result);
	}

	protected function validateAction($id) {
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

	protected function validateRoles($roles) {
		if (empty($roles)) {
			return true;
		} else {
			return Role::checkAccess($this->_employee->id, $roles);
		}
	}

	protected function validatePrivileges($privileges) {
		if (empty($privileges)) {
			return true;
		} else {
			return Privilege::checkAccess($this->_employee->id, $privileges);
		}
	}

	/**
	 * Redirect user to home if access denied
	 * @param bool $result - Filter access result
	 * @return bool - False on access denied
	 */
	private function accessDenied($result) {
		if (!$result) {
			\Yii::$app->controller->goHome();
		}
		return $result;
	}

	/**
	 * This method is invoked right after an action is executed.
	 * You may override this method to do some postprocessing for the action.
	 * @param Action $action - The action just executed.
	 * @param mixed $result - The action execution result
	 * @return mixed - The processed action result.
	 */
	public function afterAction($action, $result) {
		return $result;
	}

	private $_employee;
	private $_user;
}