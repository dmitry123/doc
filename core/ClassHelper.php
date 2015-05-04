<?php

namespace app\core;

class ClassHelper {

	public static function getProperties($class) {
		$keys = [];
		$ref = new \ReflectionClass($class);
		foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $key) {
			$keys[] = $key->getName();
		}
		return $keys;
	}
}