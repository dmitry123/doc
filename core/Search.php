<?php

namespace app\core;

use yii\base\Object;

class Search extends Object {

	/**
	 * @var array with attributes configuration for search
	 * 	provider
	 *
	 * Model Configuration:
	 *  + [label] - required parameter with column's label
	 *  + [type] - element's type [@see app\core\TypeManager::types]
	 *  + [table] - table configuration associated with another FK table
	 *  + [rules] - default validation rules separated with comma
	 *  + [source] - name of method with list for dropdown element
	 *
	 * Table Configuration:
	 *  + name - name of table in database with it's schema
	 *  + key - name of table's column with primary key constraint
	 *  + value - list with values to fetch (you can use comma to separate values)
	 *  + [format] - special format for row, use %{<column>} pattern for column alias
	 */
	public $attributes = [];

	/**
	 * @var string with compiled default search
	 *  criteria
	 */
	public $criteria = false;

	/**
	 * @var string with name of default widget that
	 * 	renders this provider
	 */
	public $widget = "app\\widgets\\Search";
}