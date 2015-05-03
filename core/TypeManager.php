<?php

namespace app\core;

class TypeManager {

	public $types = [

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

	/**
	 * Locked, use [@see getManager] method to get
	 * single instance of TypeManager class
	 */
	private function __construct() {
		/* Locked */
	}

	private static $_manager = null;
}