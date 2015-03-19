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
	 *  + 'privileges' - Array with necessary employee's privileges (require 'employee' mode)
	 *  + 'roles' - Array with necessary employee's roles (require 'employee' mode)
	 */
	public $rules = [];

	/**
	 * @var bool - That flag will be returned if you havn't declared rule for action, by
	 * 	default everything is allowed
	 */
	public $deny = false;

	/**
	 * This method is invoked right before an action is to be executed (after all possible filters), you may override
	 * 	this method to do last-minute preparation for the action
	 * @param Action $action - The action to be executed.
	 * @return boolean - Whether the action should continue to be executed.
	 */
	public function beforeAction($action) {
		if (isset($this->rules[$action->id])) {
			$rule = $this->rules[$action->id];
		} else {
			$rule = $this->rules;
		}
		if (!\Yii::$app->getUser()->getIsGuest()) {
			$user = \Yii::$app->getUser()->getIdentity();
		} else {
			$user = null;
		}
		if ($user != null) {
			$employee = Employee::model()->findOne([
				"user_id" => \Yii::$app->getUser()->getIdentity()->{"id"}
			]);
		} else {
			$employee = null;
		}
		if ($employee == null && isset($rule["roles"])) {
			return $this->accessDenied(false);
		}
		if (isset($rule["roles"])) {
			if (!Role::checkEmployeeAccess($employee->{"id"}, $rule["roles"])) {
				return $this->accessDenied(false);
			}
		}
		if ($employee == null && isset($rule["privileges"])) {
			return $this->accessDenied(false);
		}
		if (isset($rule["privileges"])) {
			if (!Privilege::checkEmployeeAccess($employee->{"id"}, $rule["privileges"])) {
				return $this->accessDenied(false);
			}
		}
		return true;
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
}