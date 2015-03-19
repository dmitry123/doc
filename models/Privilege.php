<?php

namespace app\models;

use app\core\ActiveRecord;

class Privilege extends ActiveRecord {

	public static function tableName() {
		return "core.privilege";
	}

	/**
	 * Check employee access with privilege
	 * @param int $employeeId - Employee identification number
	 * @param string|array $privilege - Privilege key (id) or array with keys
	 * @return bool - False on access denied
	 */
	public static function checkEmployeeAccess($employeeId, $privilege) {
		if (is_array($privilege)) {
			foreach ($privilege as $p) {
				if (!self::checkEmployeeAccess($employeeId, $p)) {
					return false;
				}
			}
		} else {
			$row = static::find()
				->select("count(1)")
				->from("core.privilege as p")
				->innerJoin("core.role as r", "p.role_id = p.id")
				->innerJoin("core.employee as e", "e.role_id = r.id")
				->where("e.id = :employee_id and p.id = :privilege_id", [
					":employee_id" => $employeeId,
					":privilege_id" => $privilege
				])->createCommand()
				->query();
			if (!$row) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Fetch all privileges for one role
	 * @param int $roleId - Role identification number
	 * @return array - Array with privileges
	 */
	public static function fetchByRole($roleId) {
		return static::find()
			->select("p.*")
			->from("core.privilege as p")
			->where("p.role_id = :role_id", [
				":role_id" => $roleId
			])->all();
	}

	/**
	 * Fetch all privileges for one employee
	 * @param int $employeeId - Employee identification number
	 * @return array - Array with privileges
	 */
	public static function fetchByEmployee($employeeId) {
		return static::find()
			->select("p.*")
			->from("core.privilege as p")
			->innerJoin("core.role as r", "p.role_id = r.id")
			->innerJoin("core.employee as e", "e.role_id = r.id")
			->where("e.id = :employee:id", [
				":employee_id" => $employeeId
			])->all();
	}
}