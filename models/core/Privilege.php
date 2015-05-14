<?php

namespace app\models\core;

use app\components\ActiveRecord;

class Privilege extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Уникальный ключ",
				"type" => "text",
				"rules" => "required"
			],
			"name" => [
				"label" => "Наименование",
				"type" => "text",
				"rules" => "required"
			],
			"description" => [
				"label" => "Описание",
				"type" => "textarea",
				"attributes" => [
					"cols" => "6"
				],
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return [
			[ "id", "string", "max" => 10 ],
			[ "name", "string", "max" => 100 ]
		];
	}

	public static function tableName() {
		return "core.privilege";
	}

	/**
	 * Check employee access with employee identification number and
	 * privilege's identification string or array privileges ids
	 *
	 * @param $employeeId int employee identification number
	 * @param $privilege string|array privilege identification string
	 *
	 * @return bool true on success and false on failure
	 */
	public static function checkAccess($employeeId, $privilege) {
		foreach ((array) $privilege as $p) {
			$row = static::find()
				->select("p.id")
				->from("core.privilege as p")
				->innerJoin("core.privilege_to_role as p_r", "p_r.privilege_id = p.id")
				->innerJoin("core.role as r", "p_r.role_id = r.id")
				->innerJoin("core.employee as e", "e.role_id = r.id")
				->where("e.id = :employee_id and p.id = :privilege_id", [
					":employee_id" => $employeeId,
					":privilege_id" => $p
				])->createCommand()
				->query();
			if ($row != null) {
				return true;
			}
		}
		return false;
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