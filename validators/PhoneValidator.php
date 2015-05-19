<?php

use app\core\FormModel;
use yii\validators\Validator;

class PhoneValidator extends Validator {

	public $pattern = \app\models\core\Phone::REGEXP;

	/**
	 * Validates a single attribute. This method should be overridden by child classes.
	 * @param mixed|FormModel $model - The data object being validated
	 * @param string $attribute - The name of the attribute to be validated.
	 */
	public function validateAttribute($model, $attribute) {
		if (!$this->isEmpty($model->$attribute) && !preg_match($this->pattern, "{$model->$attribute}")) {
			$this->addError($model, $attribute, "\"{attribute}\" не является телефонным номером");
		}
	}
}