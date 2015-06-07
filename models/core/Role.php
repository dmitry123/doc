<?php

namespace app\models\core;

use app\core\ActiveRecord;

class Role extends ActiveRecord {

	public function configure() {
		return [
			'id' => [
				'label' => 'Уникальный ключ',
				'type' => 'text',
				'rules' => 'required'
			],
			'name' => [
				'label' => 'Наименование',
				'type' => 'text',
				'rules' => 'required'
			],
			'description' => [
				'label' => 'Описание',
				'type' => 'textarea',
				'rules' => 'required'
			]
		];
	}

	public function rules() {
		return [
			[ 'id', 'string', 'max' => 20 ],
			[ 'name', 'string', 'max' => 100 ]
		];
	}

	public static function tableName() {
		return 'core.role';
	}

	/**
	 * Check whether employee has role or one of role
	 * from array with roles
	 *
	 * @param $id int employee identification number
	 * @param $roles array|string with roles or one role
	 *
	 * @return bool true if employee has that roles
	 */
	public static function checkEmployeeRoles($id, $roles) {
		$fetched = self::fetchByEmployee($id);
		if (!is_array($roles)) {
			$roles = [ $roles, 'super' ];
		} else {
			$roles[] = 'super';
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
		foreach ((array) $role as $r) {
			$row = static::find()->select('id')
				->from('core.employee')
				->where('role_id = :role_id and id = :employee_id', [
					':role_id' => $r,
					':employee_id' => $id,
				])->createCommand()->queryOne(\PDO::FETCH_ASSOC);
			if ($row != null) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Find all roles for one employee
	 * @param int $employeeId - Employee identification number
	 * @return array - Array with roles
	 */
	public static function fetchByEmployee($employeeId) {
		$roles = static::find()
			->select('r.*')
			->from('core.role as r')
			->innerJoin('core.employee as e', 'e.role_id = r.id')
			->where('e.id = :employee_id', [
				':employee_id' => $employeeId
			])->createCommand()
			->queryAll();
		$result = [];
		foreach ($roles as &$role) {
			$result[] = $role['id'];
		}
		return $result;
	}
}