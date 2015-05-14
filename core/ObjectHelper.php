<?php

namespace app\core;

use yii\base\Exception;

class ObjectHelper {

	const DEFAULT_CLASS = '\yii\base\Object';

	/**
	 * Create or don't create instance of class by it's
	 * configuration via Object's constructor
	 *
	 * @param $provider Object|array with class instance or
	 *  class configuration
	 *
	 * @param $class string name of class, which provider
	 *  must implements
	 *
	 * @param $defaults array with defaults parameters
	 * 	only if provider has array type
	 *
	 * @return Object instance based on provider
	 * @throws Exception
	 */
	public static function ensure($provider, $class = self::DEFAULT_CLASS, $defaults = []) {
		if ($provider === null || $provider === false) {
			return $provider;
		}
		if (is_object($provider)) {
			if (!$provider instanceof $class) {
				throw new Exception("Provider must be an instance of $class class");
			} else {
				return $provider;
			}
		} else if (is_array($provider)) {
			if (!isset($provider["class"]) || empty($provider["class"])) {
				$provider["class"] = $class;
			}
			return \Yii::createObject($provider + $defaults);
		} else {
			throw new Exception("Unknown provider type, found \"". gettype($provider) ."\"");
		}
	}
}