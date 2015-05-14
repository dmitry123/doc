<?php

namespace app\modules\doc\extensions;

use app\components\Ext;

class PlantationMasterExt extends Ext {

	public $item = null;

	function load() {
		switch ($this->item) {
			case "list":
				break;
			case "guide":
				break;
			case "configuration";
				break;
		}
	}
}