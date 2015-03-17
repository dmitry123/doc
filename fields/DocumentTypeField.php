<?php

namespace app\fields;

use app\core\DropDown;

class DocumentTypeField extends DropDown {

	/**
	 * Override that method to return associative array
	 * for drop down list
	 * @return array - Array with data
	 */
	public function data() {
		return [
		];
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "DocumentTypeField";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Тип документа";
	}
}