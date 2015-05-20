<?php

namespace app\models\doc;

use app\core\ActiveRecord;

class MacroColumn extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "number",
				"rules" => "integer"
			],
			"column" => [
				"label" => "Столбец",
				"type" => "text",
				"rules" => "required"
			],
			"macro_id" => [
				"label" => "Макрос",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.macro",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			]
		];
	}

	public static function tableName() {
		return "doc.macro_column";
	}
}