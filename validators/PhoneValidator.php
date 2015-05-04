<?php

use app\core\FormModel;
use yii\validators\Validator;

class PhoneValidator extends Validator {

	public $pattern = \app\models\core\Phone::REGEXP;

	/**
	 * Validates a single attribute. This method should be overridden by child classes.
	 * @param mixed|FormModel $object - The data object being validated
	 * @param string $attribute - The name of the attribute to be validated.
	 */
	public function validateAttribute($object, $attribute) {
		if (!$this->isEmpty($object->$attribute) && !preg_match($this->pattern, "{$object->$attribute}")) {
			$this->addError($object, $attribute, "\"{attribute}\" не является телефонным номером");
		}
	}
}