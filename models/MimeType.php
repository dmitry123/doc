<?php

namespace app\models;

use app\core\ActiveRecord;

class MimeType extends ActiveRecord {

	public static function tableName() {
		return "core.mime_type";
	}
}