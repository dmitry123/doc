<?php

namespace app\models;

use app\core\ActiveRecord;

class Country extends ActiveRecord {

	public static function tableName() {
		return "core.country";
	}
}