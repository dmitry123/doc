<?php

namespace app\models\core;

use app\core\ActiveRecord;

class Access extends ActiveRecord {

	public function configure() {
		return [
			'id' => [
				'label' => 'Идентификатор',
				'type' => 'number',
			]
		];
	}

	public function rules() {
		return [];
	}

	public static function tableName() {
		return 'core.access';
	}
}