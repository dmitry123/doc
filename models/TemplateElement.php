<?php

namespace app\models;

use app\core\ActiveRecord;

class TemplateElement extends ActiveRecord {

	public static function tableName() {
		return "doc.template_element";
	}
}