<?php

namespace app\models\core;

use app\components\ActiveRecord;

class Country extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "numerical"
			],
			"name" => [
				"label" => "Наименование",
				"type" => "text"
			]
		];
	}

	public function rules() {
		return [
			[ "name", "string", "max" => 255 ]
		];
	}

	public static function tableName() {
		return "core.country";
	}
}