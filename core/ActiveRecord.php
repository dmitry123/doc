<?php

namespace app\core;

use yii\db\Query;

abstract class ActiveRecord extends \yii\db\ActiveRecord {

	/**
	 * Override that method to return name of
	 * current table in database
	 * @return string - Name of table in database
	 */
	public abstract function getTableName();

	/**
	 * Get new query instance to build sql command
	 * @return Query - Instance of query builder
	 */
	public function createQuery() {
		return new Query();
	}
}