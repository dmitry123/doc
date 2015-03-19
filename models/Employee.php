<?php

namespace app\models;

use app\core\ActiveRecord;

class Employee extends ActiveRecord {

	public static function tableName() {
		return "core.employee";
	}
	
}