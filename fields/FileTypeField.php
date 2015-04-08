<?php

namespace app\fields;

use app\core\DropDown;

class FileTypeField extends DropDown {

	/**
	 * Override that method to return associative array
	 * for drop down list
	 * @return array - Array with data
	 */
	public function data() {
		return [
			1 => "Неизвестно",
			2 => "Документ",
			3 => "Шаблон"
		];
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "FileType";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Тип документа";
	}
}