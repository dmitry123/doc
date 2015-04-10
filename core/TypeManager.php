<?php

namespace app\core;

use yii\base\Exception;

class TypeManager {

	/**
	 * @var array - Array with model names, which override
	 * 	static methods [typeItems] and [typeLabels] from [ActiveRecord]
	 * 	class to return list with types for that model
	 *
	 * @see app\core\ActiveRecord::listTypeItems
	 * @see app\core\ActiveRecord::listTypeLabels
	 */
	public $models = [
		'app\models\Access',
		'app\models\Phone',
		'app\models\Log',
	];

	/**
	 * Get singleton type manager's instance
	 * @return TypeManager - Type manager instance
	 */
	public static function getManager() {
		if (self::$_manager == null) {
			return self::$_manager = new TypeManager();
		} else {
			return self::$_manager;
		}
	}

	public function findItems($typeName) {
		$list = $this->listItems();
		if (!isset($list[$typeName])) {
			throw new Exception("Can't resolve items for that type \"{$typeName}\"");
		}
		return $list[$typeName];
	}

	public function findLabel($typeName) {
		$list = $this->listLabels();
		if (!isset($list[$typeName])) {
			throw new Exception("Can't resolve items for that type \"{$typeName}\"");
		}
		return $list[$typeName];
	}

	public function listItems() {
		if ($this->_types !== null) {
			return $this->_types;
		} else {
			$this->_types = [];
		}
		foreach ($this->models as $class) {
			/** @var $class \app\core\ActiveRecord */
			if (($list = $class::listTypeItems()) == null) {
				continue;
			}
			foreach ($list as $key => $items) {
				$this->_types[$key] = $items;
			}
		}
		return $this->_types;
	}

	public function listLabels() {
		if ($this->_labels !== null) {
			return $this->_labels;
		} else {
			$this->_labels = [];
		}
		foreach ($this->models as $class) {
			/** @var $class \app\core\ActiveRecord */
			if (($list = $class::listTypeLabels()) == null) {
				continue;
			}
			foreach ($list as $key => $label) {
				$this->_labels[$key] = $label;
			}
		}
		return $this->_labels;
	}

	private $_labels = null;
	private $_types = null;

	/**
	 * Locked, use [@see getManager] method to get
	 * single instance of TypeManager class
	 */
	private function __construct() {
	}

	private static $_manager = null;
}