<?php

namespace app\fields;

use app\core\DropDown;

class FileStatusField extends DropDown {

	public function isBoolean() {
		return true;
	}

	/**
	 * Override that method to return associative array
	 * for drop down list
	 * @return array - Array with data
	 */
	public function data() {
		return [
			1 => "Новый",
			2 => "Старый",
			3 => "Актуальный",
			4 => "Удаленный"
		];
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "FileStatus";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Статус файла";
	}
}