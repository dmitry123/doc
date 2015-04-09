<?php

namespace app\models;

use app\core\ActiveRecord;

class Access extends ActiveRecord {

	const MODE_DENIED = 0x00;
	const MODE_READ   = 0x01;
	const MODE_WRITE  = 0x02;
	const MODE_ALL    = 0xff;

	public static function tableName() {
		return "core.access";
	}
}