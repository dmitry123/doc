<?php

namespace app\models;

use app\core\ActiveRecord;

class DocumentType extends ActiveRecord {

	public static function tableName() {
		return "doc.type";
	}
}