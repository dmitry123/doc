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
	 * Produce instance of some component via
	 * your factory singleton instance
	 *
	 * @param $module string name of module for
	 *    current component
	 *
	 * @param $id int|string identification number
	 *    of your object, which will be produced
	 *
	 * @param $params array with class parameters
	 * 	which copies to itself
	 *
	 * @return mixed instance of something
	 */
	public abstract function createEx($module, $id, $params = []);

    /**
     * Produce instance of some component via
     * your factory singleton instance
     *
     * @param $id int|string identification number
     *    of your object, which will be produced
     *
     * @param $params array with class parameters
     *    which copies to itself
     *
     * @return mixed instance of something
     */
    public function create($id, $params = []) {
        return $this->createEx(ModuleHelper::currentModuleID(), $id, $params);
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