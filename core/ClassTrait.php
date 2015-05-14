<?php

namespace app\core;

trait ClassTrait {

	/**
	 * Get class identification number without any
	 * namespaces or other symbols
	 *
	 * @return string with class identification number
	 */
	public function getID() {
		return $this->createID(get_called_class());
	}

	/**
	 * Create identification number for class with some name, you
	 * can set postfix that should be removed from class name
	 *
	 * @param $class string name of class with namespaces and
	 * 	other postfixes likes 'module' or 'controller'
	 *
	 * @param $postfix string|null with class's postfix that
	 * 	should be removed from class id
	 *
	 * @return string with class id
	 */
	public static function createID($class, $postfix = null) {
		if (($p = strrpos($class = strtolower($class), "\\")) !== false) {
			$class =  substr($class, $p + 1);
		}
		if ($postfix !== null) {
			return preg_replace("/$postfix$/i", "", $class);
		} else {
			return $class;
		}
	}
}