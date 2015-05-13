<?php

namespace app\modules\doc\extensions;

use app\core\Ext;

class PlantationMasterExt extends Ext {

	public $item = null;

	function load() {
		return "Hello, World : $this->item";
	}
}