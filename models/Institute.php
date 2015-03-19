<?php

namespace app\models;

use app\core\ActiveRecord;

class Institute extends ActiveRecord {

	public static function tableName() {
		return "core.institute";
	}
}