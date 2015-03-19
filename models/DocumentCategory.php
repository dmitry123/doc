<?php

namespace app\models;

use app\core\ActiveRecord;

class DocumentCategory extends ActiveRecord {

	public static function tableName() {
		return "doc.document_category";
	}
}