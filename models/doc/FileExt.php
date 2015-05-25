<?php

namespace app\models\doc;

use app\core\ActiveRecord;

class FileExt extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "integer"
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

	public static function findByExt($ext) {
		if (!$row = static::findOne([ "ext" => $ext ])) {
			$row = new FileExt();
			$row->setAttribute("ext", $ext);
			$row->save();
		}
		return $row;
	}

	public static function tableName() {
		return "doc.file_ext";
	}
}