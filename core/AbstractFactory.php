<?php

namespace app\core;

abstract class AbstractFactory implements Factory {

	/**
	 * Get singleton instance of current factory
	 * class to produce some components
	 *
	 * @return null|static instance of
	 * 	component
	 */
	public static function getFactory() {
		if (static::$_factory == null) {
			return static::$_factory = new static();
		} else {
			return static::$_factory;
		}
	}

	/**
	 * Cache some component in factory by it's
	 * identification number (int or string)
	 *
	 * @param int|string $id component's
	 * @param mixed $mixed instance of element
	 */
	public function cache($id, &$mixed) {
		if (is_object($mixed)) {
			$obj = clone $mixed;
		} else {
			$obj = $mixed;
		}
		static::$_cached[$id] = $obj;
	}

	private function __construct() {
		/* Locked */
	}

	public static $_cached = [];
	public static $_factory = null;
}