<?php

namespace app\filters;

use app\models\Employee;
use app\models\Privilege;
use app\models\Role;
use yii\base\Action;
use yii\base\ActionFilter;

class AccessFilter extends ActionFilter {

	/**
	 * @var array - Array with actions rules, where every action can contains next keys:
	 *  + 'on' - Array with allowed modes (default - full access denied):
	 *  + + 'guest' - Only for guests
	 *  + + 'user' - Only for users
	 *  + + 'employee' - Only for employees
	 *  + + 'full' - Full access for every class
	 *  + 'privileges' - Array with necessary employee's privileges (require 'employee' mode)
	 *  + 'roles' - Array with necessary employee's roles (require 'employee' mode)
	 */
	public $rules = [];

	/**
	 * @var bool - That flag will be returned if you havn't declared rule for action, by
	 * 	default everything is allowed
	 */
	public $deny = true;

	/**
	 * This method is invoked right before an action is to be executed (after all possible filters), you may override
	 * 	this method to do last-minute preparation for the action
	 * @param Action $action - The action to be executed.
	 * @return boolean - Whether the action should continue to be executed.
	 */
	public function beforeAction($action) {
		if (!isset($this->rules[$action->id])) {
			return $this->deny;
		}
		$rule = $this->rules[$action->id];
		if (!\Yii::$app->getUser()->getIsGuest()) {
			$user = \Yii::$app->getUser()->getIdentity();
		} else {
			$user = null;
		}
		if ($user != null) {
			$employee = Employee::model()->findOne([
				"user_id" => \Yii::$app->getUser()->getIdentity()->{"id"}
			]);
			if ($employee != null) {
				$roles = Role::fetchByEmployee($employee->{"id"});
			}
		} else {
			$employee = null;
		}
		if (!isset($roles)) {
			$roles = [];
		}
		if ($employee != null) {
			$privileges = Privilege::fetchByEmployee($employee->{"id"});
		} else {
			$privileges = [];
		}
		if (isset($rule["on"])) {
			$mode = $rule["on"];
			$r = false;
			if (in_array("employee", $mode)) {
				$r = $employee != null;
			} else if (in_array("user", $mode)) {
				$r = $user != null;
			} else if (in_array("guest", $mode)) {
				$r = true;
			}
			if (!$r) {
				return false;
			}
		}
		foreach ($rule["roles"] as $role) {
			foreach ($roles as $r) {
				if ($r["id"] != $role) {
					return false;
				}
			}
		}
		foreach ($rule["privileges"] as $privilege) {
			foreach ($privileges as $p) {
				if ($p["id"] != $privilege) {
					return false;
				}
			}
		}
		return true;
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
}