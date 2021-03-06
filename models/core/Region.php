<?php

namespace app\models\core;

use app\core\ActiveRecord;

class Region extends ActiveRecord {

	public function configure() {
		return [
			'id' => [
				'label' => 'Идентификатор',
				'type' => 'hidden',
				'rules' => 'integer'
			],
			'name' => [
				'label' => 'Название',
				'type' => 'text',
				'rules' => 'required'
			],
			'country_id' => [
				'label' => 'Страна',
				'type' => 'DropDown',
				'table' => [
					'name' => 'core.country',
					'key' => 'id',
					'value' => 'name'
				],
				'rules' => 'required'
			]
		];
	}

	public function rules() {
		return [
			[ 'name', 'string', 'max' => 255 ]
		];
	}

	public static function tableName() {
		return 'core.region';
	}
}