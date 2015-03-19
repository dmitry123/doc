<?php

namespace app\models;

use app\core\ActiveRecord;

class Role extends ActiveRecord {

	public static function tableName() {
		return "core.role";
	}

	/**
	 * @param null $class
	 * @return Role
	 */
	public static function model($class = null) {
		return parent::model($class);
	}

	/**
	 * Check whether employee has role
	 * @param int $employeeId - Employee identification number
	 * @param array|string $roles - Array with roles or simply one string
	 * @return bool - True if employee has that roles
	 */
	public static function checkEmployeeRoles($employeeId, $roles) {
		$fetched = self::fetchByEmployee($employeeId);
		if (!is_array($roles)) {
			return in_array($roles, $fetched);
		}
		foreach ($roles as $r) {
			if (!in_array($r, $fetched)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Find all roles for one employee
	 * @param int $employeeId - Employee identification number
	 * @return array - Array with roles
	 */
	public static function fetchByEmployee($employeeId) {
		$roles = static::find()
			->select("r.*")
			->from("role as r")
			->innerJoin("employee as e", "e.role_id = r.id")
			->where("e.id = :employee_id", [
				":employee_id" => $employeeId
			])->createCommand()
			->queryAll();
		$result = [];
		foreach ($roles as &$role) {
			$result[] = $role["id"];
		}
		return $result;
	}
}