<?php

namespace app\models;

use app\core\ActiveRecord;

class Department extends ActiveRecord {

	public static function tableName() {
		return "core.department";
	}
}