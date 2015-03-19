<?php

namespace app\models;

use app\core\ActiveRecord;

class Template extends ActiveRecord {

	public static function tableName() {
		return "doc.template";
	}
}