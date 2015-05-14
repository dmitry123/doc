<?php

namespace app\models\doc;

use app\core\ActiveRecord;

class FileStatus extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "text",
				"rules" => "required"
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
			[ "id", "string", "max" => 10 ],
			[ "name", "string", "max" => 50 ]
		];
	}

	public static function tableName() {
		return "doc.file_status";
	}
}