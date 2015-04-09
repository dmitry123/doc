<?php

namespace app\models;

use app\core\ActiveRecord;

class FileType extends ActiveRecord {

	public static function tableName() {
		return "core.file_status";
	}
}