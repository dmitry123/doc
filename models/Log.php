<?php

namespace app\models;

use app\core\ActiveRecord;

class Log extends ActiveRecord {

	public static function tableName() {
		return "doc.log";
	}
}