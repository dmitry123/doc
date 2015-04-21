<?php

namespace app\fields;

use app\core\DropDown;
use app\models\Access;

class AccessModeField extends DropDown {

	/**
	 * Override that method to return associative array
	 * for drop down list
	 * @return array - Array with data
	 */
	public function data() {
		return [
			Access::MODE_DENIED => "Закрыт",
			Access::MODE_READ => "Чтение",
			Access::MODE_WRITE => "Запись",
			Access::MODE_ALL => "Полный"
		];
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "Access";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Уровень доступа";
	}
}