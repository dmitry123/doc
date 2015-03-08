<?php

namespace app\core;

use yii\base\ErrorException;
use yii\db\Query;

abstract class ActiveRecord extends \yii\db\ActiveRecord {

	/**
	 * Override that method to return name of
	 * current table in database
	 * @return string - Name of table in database
	 */
	public abstract function getTableName();

	/**
	 * Find model by it's name
	 * @param string $class - Name of model class or null (default)
	 * @return ActiveRecord - Active record class instance
	 */
	public static function model($class = null) {
		if ($class == null) {
			$class = get_called_class();;
		}
		if (!isset(static::$cached[$class])) {
			return (static::$cached[$class] = new static());
		} else {
			return static::$cached[$class];
		}
	}

	private static $cached = [];

	/**
	 * Moved from Yii 1.1 for backward compatibility
	 * @param int|string $id - Primary key value
	 * @return integer|false - The number of rows deleted, or false if the deletion is unsuccessful for some reason
	 * @throws ErrorException - Will be thrown, if table hasn't primary key
	 * @throws \Exception
	 */
	public function deleteByPk($id) {
		$keys = $this->primaryKey();
		if (!isset($keys[0])) {
			throw new ErrorException("Unresolved table primary key");
		}
		$pk = $keys[0];
		$this->$pk = $id;
		return $this->delete();
	}

	/**
	 * Get new query instance to build sql command
	 * @return Query - Instance of query builder
	 */
	public function createQuery() {
		return new Query();
	}
}