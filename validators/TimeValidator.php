<?php

namespace app\validators;

use app\core\Validator;

class TimeValidator extends Validator {

	const REGEXP = '/^\d{2}:\d{2}&/';

	protected function validateValue($value) {
		return preg_match(static::REGEXP, $value) == 1;
	}
}