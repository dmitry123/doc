<?php

namespace app\models;

use app\core\ActiveRecord;

class City extends ActiveRecord {

	public static function tableName() {
		return "core.city";
	}
}