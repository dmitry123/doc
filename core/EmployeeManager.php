<?php

namespace app\core;

use app\models\Employee;
use yii\base\Object;

class EmployeeManager {

	const NORMAL = 0;
	const SHORT = 1;
	const FULL = 2;

	private function __construct() {
		if (!\Yii::$app->getUser()->getIsGuest()) {
			$this->employee = Employee::findOne([
				"user_id" => \Yii::$app->getUser()->getIdentity()->{"id"}
			]);
		} else {
			$this->employee = null;
		}
	}

	public static function getManager() {
		if (self::$manager == null) {
			return self::$manager = new EmployeeManager();
		} else {
			return self::$manager;
		}
	}

	public static $manager = null;

	public function getEmployee() {
		return $this->employee;
	}

	public function isValid() {
		return $this->employee != null;
	}

	private $employee;

	public static function getInfo($userId = null) {
		if ($userId == null) {
			if (\Yii::$app->getUser()->getIdentity() == null) {
				return null;
			}
			$userId = \Yii::$app->getUser()->getIdentity()->{"id"};
		}
		if (isset(self::$_cached[$userId])) {
			return self::$_cached[$userId];
		}
		$employee = Employee::find()->select("*")->from("core.employee_info")->where([
			"user_id" => $userId
		])->createCommand()->queryOne();
		if ($employee === false) {
			return null;
		}
		return self::$_cached[$userId] = $employee;
	}

	public static function getIdentity($fio = self::NORMAL) {
		if (($employee = self::getInfo()) == null) {
			return "";
		}
		$result = $employee["surname"];
		switch ($fio) {
			case self::NORMAL:
				$name = " ".$employee["name"];
				break;
			case self::SHORT:
				$name = " ".strtoupper(substr($employee["name"], 0, 2)).".";
				$patronymic = strtolower(substr($employee["patronymic"], 0, 2));
				break;
			case self::FULL:
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

	private static $_cached = [];
}