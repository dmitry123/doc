<?php

namespace app\models;

use app\core\ActiveRecord;

class History extends ActiveRecord {

	public static function tableName() {
		return "doc.history";
	}
}