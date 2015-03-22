<?php

namespace app\widgets;

use app\core\Widget;
use app\models\Employee;
use app\models\Role;
use yii\helpers\Html;

class Navigation extends Widget {

	public $menu = [
		"admin" => [
			"label" => "Администратор",
			"items" => [
				"admin/tables" => "Таблица",
				"admin/statistics" => "Статистика"
			],
			"roles" => [ "admin" ]
		]
	];

	public function renderItem($item) {
		print Html::beginTag("li");

		print Html::endTag("li");
	}

	/**
	 * Run widget
	 * @return string - Rendered content
	 */
	public function run() {
		$identity = \Yii::$app->getUser()->getIdentity();
		$this->employee = Employee::findOne([
			"user_id" => $identity->{"id"}
		]);
		if ($this->employee != null) {
			$admin = Role::checkEmployeeRoles($this->employee->{"id"}, "admin");
		} else {
			$admin = false;
		}
		return $this->render("Navigation", [
			"admin" => $admin
		]);
	}

	/**
	 * Check employee access
	 * @param array|string $roles - Array with roles or string with role id
	 * @return bool - False on access denied
	 */
	private function checkAccess($roles) {
		if ($this->employee != null) {
			return Role::checkEmployeeRoles($this->employee->{"id"}, $roles);
		} else {
			return false;
		}
	}

	private $employee;
}