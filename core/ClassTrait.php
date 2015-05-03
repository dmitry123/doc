<?php

namespace app\core;

trait ClassTrait {

	public function getID() {
		return $this->createID(get_called_class());
	}

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