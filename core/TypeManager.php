<?php

namespace app\core;

class TypeManager {

	/**
	 * @var array - Array with model names, which override
	 * 	static methods [typeItems] and [typeLabels] from [ActiveRecord]
	 * 	class to return list with types for that model
	 *
	 * @see app\core\ActiveRecord::typeItems
	 * @see app\core\ActiveRecord::typeLabels
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

	public function findType($typeName) {

	}

	/**
	 * Locked, use [@see getManager] method to get
	 * single instance of TypeManager class
	 */
	private function __construct() {
	}

	private static $_manager = null;
}