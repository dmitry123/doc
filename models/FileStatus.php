<?php

namespace app\models;

use app\core\ActiveRecord;

class FileStatus extends ActiveRecord {

	public static function tableName() {
		return "core.file_status";
	}
}