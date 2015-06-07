<?php

namespace app\core;

use yii\base\Exception;
use yii\helpers\Inflector;

abstract class ActiveRecord extends \yii\db\ActiveRecord {

	/**
	 * Default schema, that used to be added before
	 * table name in [tableName] method
	 *
	 * @see ActiveRecord::tableName
	 */
	const DEFAULT_SCHEMA = "core";

	/**
	 * Create an active record instance with another model
	 * class or array with attributes, it will create new
	 * instance of static class and copy all model attributes
	 * to it
	 *
	 * @param $model Model|array with attributes to copy, if type doesn't
	 * 	match [Model] or [array], then exception will be thrown
	 *
	 * @return static instance of current active record class
	 * @throws Exception if type doesn't matches array or Model object
	 */
	public static function createWithModel($model = []) {
		$var = new static();
		if ($model instanceof Model) {
			$attributes = $model->getAttributes();
		} else if (is_array($model)) {
			$attributes = $model;
		} else {
			throw new Exception("Invalid model type, requires FormModel class instance or array");
		}
		foreach ($attributes as $key => $value) {
			$var->setAttribute($key, $value);
		}
		return $var;
	}

	/**
	 * Override that method to configure your active record model, it
	 * should return configuration for every field associated with column
	 * in database
	 *
	 * Model Configuration:
	 *  + label - required parameter with column's label
	 *  + type - element's type key [@see app\core\TypeManager::types]
	 *  + [table] - table configuration associated with another FK table
	 *  + [rules] - default validation rules separated with comma
	 *  + [source] - name of method with list for dropdown element
	 *
	 * Table Configuration:
	 *  + name - name of table in database with it's schema
	 *  + key - name of table's column with primary key constraint
	 *  + value - list with values to fetch (you can use comma to separate values)
	 *  + [format] - special format for row, use %{<column>} pattern for column alias
	 *
	 * @return array with model configuration
	 */
	public abstract function configure();

	/**
	 * Get configuration for current active record class for
	 * all class or only one field
	 *
	 * @param $key null|string with name of database column
	 * 	which configuration u'd like to get
	 *
	 * @return null|array with column or model
	 * 	configuration
	 */
	public function getConfig($key = null) {
		if ($this->_config == null) {
			$this->_config = $this->configure();
		}
		if ($key != null) {
			return isset($this->_config[$key]) ? $this->_config[$key] : null;
		} else {
			return $this->_config;
		}
	}

	/**
	 * Get configuration manager for current instance of
	 * active record class, it build columns config and
	 * can return compiled array with Yii configurations via
	 * finalize method
	 *
	 * @return ConfigManager instance of configuration manager
	 * 	class with built attributes
	 *
	 * @see ConfigManager::build
	 * @see ConfigManager::finalize
	 */
	public function getManager() {
		if ($this->_manager == null) {
			return $this->_manager = ConfigManager::createManager($this->getConfig());
		} else {
			return $this->_manager;
		}
	}

	/**
	 * Get table name from class path with namespace, we think
	 * that default table's schema is core. It reflects current
	 * class and converts it's name from camel case to id case
	 *
	 * @return string name of table from class's name
	 */
	public static function tableName() {
		return static::DEFAULT_SCHEMA.".".Inflector::camel2id(preg_replace("/^.*\\\\/", "", get_called_class()), "_");
	}

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
	 * Get array with labels for every column
	 * in current active record class
	 *
	 * @return array with column labels
	 */
	public function attributeLabels() {
		return $this->getManager()->labels;
	}

	private $_config = null;
	private $_manager = null;
}