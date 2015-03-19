<?php

namespace app\models;

use app\core\ActiveRecord;

class Document extends ActiveRecord {

	public static function tableName() {
		return "doc.document";
	}
}