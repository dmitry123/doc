<?php

namespace app\modules\doc\extensions;

use app\core\Ext;
use app\modules\doc\widgets\Plantation;

class PlantationExt extends Ext {

	/**
	 * Override that method to load your extension from
	 * widget or another view file to return it's content
	 *
	 * @return string just rendered content which your
	 *    extension component produces
	 */
	function load() {
		return Plantation::widget();
	}
}