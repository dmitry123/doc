<?php

namespace app\models;

use app\core\ActiveRecord;

class Privilege extends ActiveRecord {

	/**
	 * Fetch all privileges for one role
	 * @param int $roleId - Role identification number
	 * @return array - Array with privileges
	 */
	public static function fetchByRole($roleId) {
		return static::find()
			->select("p.*")
			->from("privilege as p")
			->innerJoin("privilege_to_role as pr", "pr.privilege_id = p.id")
			->where("pr.role_id = :role_id", [
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
			->from("privilege as p")
			->innerJoin("privilege_to_role as pr", "pr.privilege_id = p.id")
			->innerJoin("role_to_employee as re", "re.role_id = pr.role_id")
			->where("re.employee_id = :employee_id", [
				":employee_id" => $employeeId
			])->all();
	}
}