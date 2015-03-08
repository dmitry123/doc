<?php

namespace app\fields;

use app\core\DropDown;

class PhoneTypeField extends DropDown {

	/**
	 * Override that method to make that field as boolean type
	 * @return bool - True, if your subtype is boolean like
	 */
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
			0 => "Городской",
			1 => "Мобильный",
            2 => "Служебный"
		];
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "PhoneType";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Тип телефона";
	}
}