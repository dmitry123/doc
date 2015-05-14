<?php

namespace app\models\doc;

use app\core\ActiveRecord;

class FileType extends ActiveRecord {

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
			],
			"description" => [
				"label" => "Описание",
				"type" => "textarea"
			],
		];
	}

	public function rules() {
		return [
			[ "id", "string", "max" => 10 ],
			[ "name", "string", "max" => 30 ]
		];
	}

	public static function tableName() {
		return "doc.file_type";
	}

	public static function findNotUnknown() {
		return static::find()->select("*")
			->from("doc.file_type")
			->where("id <> 'unknown'")
			->all();
	}
}