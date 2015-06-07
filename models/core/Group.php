<?php

namespace app\models\core;

use app\core\ActiveRecord;

class Group extends ActiveRecord {

	public function configure() {
		return [
			'id' => [
				'label' => 'Идентификатор',
				'type' => 'number',
			],
			'parent_id' => [
				'label' => 'Родитель',
				'type' => 'dropdown',
				'table' => [
					'name' => 'group',
					'key' => 'id',
					'value' => 'name',
				],
			],
			'name' => [
				'label' => 'Название',
				'type' => 'text',
			],
		];
	}

	public function rules() {
		return [
			[ 'name', 'string', 'max' => 100 ],
		];
	}

	public static function tableName() {
		return 'core.group';
	}
}