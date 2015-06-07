<?php

namespace app\models\core;

use app\core\ActiveRecord;

class Department extends ActiveRecord {

	public function configure() {
		return [
			'id' => [
				'label' => 'Идентификатор',
				'type' => 'hidden',
				'rules' => 'integer'
			],
			'name' => [
				'label' => 'Наименование',
				'type' => 'text',
				'rules' => 'required'
			],
			'institute_id' => [
				'label' => 'Институт',
				'type' => 'DropDown',
				'table' => [
					'name' => 'core.institute',
					'key' => 'id',
					'value' => 'name'
				],
				'rules' => 'required'
			],
			'manager_id' => [
				'label' => 'Заведующий',
				'type' => 'DropDown',
				'table' => [
					'name' => 'core.about_employee',
					'key' => 'id',
					'format' => '%{surname} %{name} %{patronymic} (%{role_name})',
					'value' => 'surname, name, patronymic, role_name'
				],
				'rules' => 'required'
			]
		];
	}

	public function rules() {
		return [
			[ 'name', 'string', 'max' => 100 ]
		];
	}

	public static function tableName() {
		return 'core.department';
	}
}