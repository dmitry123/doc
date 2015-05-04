<?php

namespace app\core;

use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

abstract class ActiveRecord extends \yii\db\ActiveRecord {

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
	public static function createWithModel($model) {
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
	 * Create new instance of table provider class for
	 * current active record class
	 *
	 * @param $fetchQuery Query to fetch rows from
	 *  database's table
	 *
	 * @return TableProvider instance of table provider class
	 */
	public static function createTableProvider($fetchQuery) {
		return new TableProvider(new static(), $fetchQuery);
	}

	/**
	 * Create default instance of table provider with default [fetchQuery]
	 * and [countQuery] queries for [@see app\widgets\Table] widget
	 *
	 * @param $model string|null name of active record class
	 *
	 * @see TableProvider::fetchQuery
	 * @see TableProvider::countQuery
	 *
	 * @return TableProvider
	 */
	public static function getDefaultTableProvider($model = null) {
		$model = $model != null ? $model : get_called_class();
		return new TableProvider(new $model());
	}

	/**
	 * Moved from Yii 1.1 for backward compatibility with some
	 * methods which has been moved from old projects
	 *
	 * @param $id int|string unique primary key value
	 *
	 * @return integer|false the number of rows deleted, or false
	 * 	if the deletion is unsuccessful for some reason
	 *
	 * @throws ErrorException will be thrown, if table hasn't
	 * 	primary key
	 *
	 * @throws \Exception
	 */
	public function deleteByPk($id) {
		return $this->deleteAll([
			$this->getTableSchema()->primaryKey[0] => $id
		]);
	}
}