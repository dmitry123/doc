<?php

namespace app\models\doc;

use app\components\ActiveRecord;

class FileExt extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Наименование",
				"type" => "hidden",
				"rules" => "numerical"
			],
			"ext" => [
				"label" => "Расширение",
				"type" => "text",
				"rules" => "required"
			],
		];
	}

	public function rules() {
		return [
			[ "ext", "string", "max" => 50 ]
		];
	}

	public static function tableName() {
		return "doc.file_ext";
	}
}