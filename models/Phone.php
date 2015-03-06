<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.03.15
 * Time: 20:42
 */

namespace app\models;

use app\core\ActiveRecord;

class Phone extends ActiveRecord {

	/**
	 * Override that method to return name of
	 * current table in database
	 * @return string - Name of table in database
	 */
	public function getTableName() {
		return "phone";
	}
}