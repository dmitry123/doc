<?php

namespace app\models;

class Document extends \app\core\ActiveRecord {

	public static function tableName() {
		return "core.document";
	}
}