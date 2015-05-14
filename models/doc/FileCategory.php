<?php

namespace app\models\doc;

use app\components\ActiveRecord;

class FileCategory extends ActiveRecord {

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
			]
		];
	}

	public function rules() {
		return [
			[ "name", "string", "max" => 100 ]
		];
	}

	public static function tableName() {
		return "doc.file_category";
	}
}