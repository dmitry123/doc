<?php

namespace app\models\doc;

use app\core\ActiveRecord;

class FileMacro extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "number",
				"rules" => "integer"
			],
			"macro_id" => [
				"label" => "Макрос",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.macro",
					"key" => "id",
					"value" => "name"
				]
			],
			"file_id" => [
				"label" => "Шаблон",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.template",
					"key" => "id",
					"value" => "name"
				]
			],
			"path" => [
				"label" => "Путь",
				"type" => "text"
			]
		];
	}

	public function rules() {
		return [];
	}

	public static function tableName() {
		return "doc.file_macro";
	}
}