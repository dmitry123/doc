<?php

namespace app\models;

use app\core\ActiveRecord;

class Region extends ActiveRecord {

	public static function tableName() {
		return "core.region";
	}
}