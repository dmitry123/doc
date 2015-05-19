<?php

namespace app\models\core;

use app\core\ActiveRecord;

class City extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Первичный ключ",
				"type" => "hidden",
				"rules" => "integer"
			],
			"name" => [
				"label" => "Наименование",
				"type" => "text",
				"rules" => "required"
			],
			"country_id" => [
				"label" => "Страна",
				"type" => "DropDown",
				"table" => [
					"name" => "core.country",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			],
			"region_id" => [
				"label" => "Регион",
				"type" => "DropDown",
				"table" => [
					"name" => "core.region",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return [
			[ "name", "string", "max" => 255 ]
		];
	}

	public static function tableName() {
		return "core.city";
	}
}