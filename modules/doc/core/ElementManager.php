<?php

namespace app\modules\doc\core;

use app\core\TypeManager;

class ElementManager extends TypeManager {

	private $_types = [
		"macros" => [
			"label" => "Макрос"
		]
	];

	public function getTypes() {
		return parent::getTypes() + $this->_types;
	}
}