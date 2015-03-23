<?php

namespace app\core;

use app\models\Employee;
use yii\base\Object;

class EmployeeManager extends Object {

	const NORMAL = 0;
	const SHORT = 1;
	const FULL = 2;

	public static function getInfo($userId = null) {
		if ($userId == null) {
			$userId = \Yii::$app->getUser()->getIdentity()->{"id"};
		}
		if (isset(self::$_cached[$userId])) {
			return self::$_cached[$userId];
		}
		$employee = Employee::find()->select("*")->from("core.employee_info")->where([
			"user_id" => $userId
		])->createCommand()->queryOne();
		if ($employee === false) {
			return [];
		}
		return self::$_cached[$userId] = $employee;
	}

	public static function getIdentity($fio = self::NORMAL) {
		$employee = self::getInfo();
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