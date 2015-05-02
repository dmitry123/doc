<?php

namespace app\models;

use app\core\ActiveRecord;

class Role extends ActiveRecord {

	public static function tableName() {
		return "core.role";
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
			$roles = [ $roles, "super" ];
		} else {
			$roles[] = "super";
		}
		foreach ($roles as $r) {
			if (in_array($r, $fetched)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Check employee access roles
	 * @param int $id - Employee identification number
	 * @param string|array $role - Role name (id) or array with roles
	 * @return bool - False is access denied
	 */
	public static function checkAccess($id, $role) {
		if (is_array($role)) {
			foreach ($role as $r) {
				if (self::checkAccess($id, $r)) {
					return true;
				}
			}
			return false;
		} else {
			$row = static::find()->select("id")
				->from("core.employee")
				->where("role_id = :role_id and id = :employee_id", [
					":role_id" => $role,
					":employee_id" => $id,
				])->createCommand()->queryOne(\PDO::FETCH_ASSOC);
			return $row != null;
		}
	}

	/**
	 * Find all roles for one employee
	 * @param int $employeeId - Employee identification number
	 * @return array - Array with roles
	 */
	public static function fetchByEmployee($employeeId) {
		$roles = static::find()
			->select("r.*")
			->from("core.role as r")
			->innerJoin("core.employee as e", "e.role_id = r.id")
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