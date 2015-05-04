<?php

namespace app\core;

use app\models\core\Employee;

class EmployeeManager {

	const IDENTITY_NORMAL = 0;
	const IDENTITY_SHORT = 1;
	const IDENTITY_FULL = 2;

	public static function getManager() {
		if (self::$_manager == null) {
			return self::$_manager = new EmployeeManager();
		} else {
			return self::$_manager;
		}
	}

	public function getInfo($userId = null) {
		if ($userId == null) {
			if (\Yii::$app->getUser()->getIdentity() == null) {
				return null;
			}
			$userId = \Yii::$app->getUser()->getIdentity()->{"id"};
		}
		if (isset(self::$_cached[$userId])) {
			return self::$_cached[$userId];
		}
		$employee = Employee::find()->select("*")->from("core.about_employee")->where([
			"user_id" => $userId
		])->createCommand()->queryOne();
		if ($employee === false) {
			return null;
		}
		return self::$_cached[$userId] = $employee;
	}

	public function getIdentity($fio = self::IDENTITY_NORMAL) {
		if (($employee = $this->getInfo()) == null) {
			return "";
		}
		$result = $employee["surname"];
		switch ($fio) {
			case self::IDENTITY_NORMAL:
				$name = " ".$employee["name"];
				break;
			case self::IDENTITY_SHORT:
				$name = " ".strtoupper(substr($employee["name"], 0, 2)).".";
				$patronymic = strtolower(substr($employee["patronymic"], 0, 2));
				break;
			case self::IDENTITY_FULL:
				$name = " ".$employee["name"];
				$patronymic = " ".$employee["patronymic"];
				break;
			default:
				return "";
		}
		if (!empty($name)) {
			$result .= $name;
		}
		if (!empty($patronymic)) {
			$result .= $patronymic;
		}
		return $result;
	}

	public function getEmployee() {
		return $this->employee;
	}

	public function isValid() {
		return $this->employee != null;
	}

	private function __construct() {
		if (!\Yii::$app->getUser()->getIsGuest()) {
			$this->employee = Employee::findOne([
				"user_id" => \Yii::$app->getUser()->getIdentity()->{"id"}
			]);
		} else {
			$this->employee = null;
		}
	}

	private $employee;

	private static $_manager = null;
	private static $_cached = [];
}