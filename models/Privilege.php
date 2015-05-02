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
	public static function checkAccess($employeeId, $privilege) {
		if (is_array($privilege)) {
			foreach ($privilege as $p) {
				if (self::checkAccess($employeeId, $p)) {
					return true;
				}
			}
			return false;
		}
		$row = static::find()
			->select("p.id")
			->from("core.privilege as p")
			->innerJoin("core.privilege_to_role as p_r", "p_r.privilege_id = p.id")
			->innerJoin("core.role as r", "p_r.role_id = r.id")
			->innerJoin("core.employee as e", "e.role_id = r.id")
			->where("e.id = :employee_id and p.id = :privilege_id", [
				":employee_id" => $employeeId,
				":privilege_id" => $privilege
			])->createCommand()
			->query();
		return $row != null;
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