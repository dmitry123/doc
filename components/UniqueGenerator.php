<?php

namespace app\components;

use yii\base\Object;

class UniqueGenerator extends Object {

	/**
	 * Generate random identification number for some element
	 * @param string $prefix - Element's prefix, like 'form' or 'modal'
	 * @param int $length - Random key length (in bytes)
	 * @return string - Generated unique key
	 */
	public static function generate($prefix, $length = 10) {
		return $prefix ."-". bin2hex(\Yii::$app->getSecurity()->generateRandomKey($length / 2));
	}
}