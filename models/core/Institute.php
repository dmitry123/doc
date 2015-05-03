<?php

namespace app\models\core;

use app\core\ActiveRecord;

class Institute extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "numerical"
			],
			"name" => [
				"label" => "Наименование",
				"type" => "text",
				"rules" => "required"
			],
			"director_id" => [
				"label" => "Директор",
				"type" => "DropDown",
				"table" => [
					"name" => "core.about_employee",
					"format" => "%{surname} %{name} %{patronymic} (%{role_name})",
					"key" => "id",
					"value" => "surname, name, patronymic, role_name"
				],
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return [
			[ "name", "string", "max" => 100 ]
		];
	}

	public static function tableName() {
		return "core.institute";
	}
}