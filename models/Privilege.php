<?php

namespace app\models;

use app\core\ActiveRecord;

class Privilege extends ActiveRecord {

	public static function tableName() {
		return "core.privilege";
	}

	/**
	 * Fetch all privileges for one role
	 * @param int $roleId - Role identification number
	 * @return array - Array with privileges
	 */
	public static function fetchByRole($roleId) {
		return static::find()
			->select("p.*")
			->from("privilege as p")
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
			->from("privilege as p")
			->innerJoin("role as r", "p.role_id = r.id")
			->innerJoin("employee as e", "e.role_id = r.id")
			->where("e.id = :employee:id", [
				":employee_id" => $employeeId
			])->all();
	}
}