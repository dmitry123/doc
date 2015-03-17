<?php

namespace app\core;

use yii\base\ErrorException;
use yii\db\Query;
use yii\helpers\Inflector;

abstract class ActiveRecord extends \yii\db\ActiveRecord {

	/**
	 * Construct active record with another model and configuration
	 * @param FormModel $model - Another model to clone
	 * @param array $config - Configuration
	 */
	public function __construct($model = null, $config = []) {
		parent::__construct($config);
		if ($model != null) {
			foreach ($model->getAttributes() as $key => $value) {
				$this->setAttribute($key, $value);
			}
		}
	}

	/**
	 * Get table name from class path with namespace
	 * @return string - Name of table from class's name
	 */
	public static function tableName() {
		return Inflector::camel2id(preg_replace("/^.*\\\\/", "", get_called_class()));
	}

	/**
	 * Find model by it's name
	 * @param string $class - Name of model class or null (default)
	 * @return ActiveRecord - Active record class instance
	 */
	public static function model($class = null) {
		if ($class == null) {
			$class = get_called_class();;
		}
		if (!isset(self::$models[$class])) {
			return (self::$models[$class] = new $class());
		} else {
			return self::$models[$class];
		}
	}

	private static $models = [];

	/**
	 * Get array with validation rules for current class
	 * @param $extra array - Additional validation rules (for hidden fields)
	 * @return array - Array with validation rules
	 */
	public static function getRules($extra = []) {
		if (!self::$rules) {
			return (self::$rules = array_merge(static::model()->rules(), $extra));
		} else {
			return self::$rules;
		}
	}

	private static $rules = null;

	/**
	 * Returns attribute values.
	 * @param array $names list of attributes whose value needs to be returned.
	 * Defaults to null, meaning all attributes listed in [[attributes()]] will be returned.
	 * If it is an array, only the attributes in the array will be returned.
	 * @param array $except list of attributes whose value should NOT be returned.
	 * @return array attribute values (name => value).
	 */
	public function getAttributes($names = null, $except = []) {
		$values = [];
		if ($names === null) {
			$names = $this->attributes();
		}
		foreach ($names as $name) {
			$values[$name] = $this->$name;
		}
		foreach ($except as $name) {
			unset($values[$name]);
		}
		foreach ($values as $key => &$v) {
			if (empty($v)) {
				unset($values[$key]);
			}
		}
		return $values;
	}

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
	 * Helper method to get table's name for dynamic context
	 * @return string - Name of table
	 */
	public function getTableName() {
		return static::tableName();
	}

	/**
	 * Get new query instance to build sql command
	 * @return Query - Instance of query builder
	 */
	public function createQuery() {
		return new Query();
	}
}