<?php

namespace app\models;

use app\core\ActiveRecord;

class Phone extends ActiveRecord {

	public static function tableName() {
		return "core.phone";
	}
}