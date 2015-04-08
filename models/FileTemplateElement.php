<?php

namespace app\models;

use app\core\ActiveRecord;

class FileTemplateElement extends ActiveRecord {

	public static function tableName() {
		return "core.file_template_element";
	}
}