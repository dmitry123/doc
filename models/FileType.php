<?php

namespace app\models;

use app\core\ActiveRecord;

class FileType extends ActiveRecord {

	public static function findNotUnknown() {
		return static::find()->select("*")
			->from("core.file_type")
			->where("id <> 'unknown'")
			->all();
	}

	public static function tableName() {
		return "core.file_type";
	}
}