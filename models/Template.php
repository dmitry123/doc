<?php

namespace app\models;

use app\core\ActiveRecord;

class Template extends ActiveRecord {

	/**
	 * Override that method to return name of
	 * current table in database
	 * @return string - Name of table in database
	 */
	public function getTableName() {
		return "template";
	}
}