<?php

namespace app\fields;

use app\core\DropDown;

class LogActionField extends DropDown {

	/**
	 * Override that method to return associative array
	 * for drop down list
	 * @return array - Array with data
	 */
	public function data() {
		return [
			1 => "Добавление документа",
			2 => "Редактирование документа",
			3 => "Удаление документа"
		];
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "LogAction";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Действие";
	}
}