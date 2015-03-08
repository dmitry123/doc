<?php

namespace app\validators;

use app\core\FormModel;
use Yii;

class RequiredValidator extends \yii\validators\RequiredValidator {

	/**
	 * Validates a single attribute. This method should be overridden by child classes.
	 * @param mixed|FormModel $object - The data object being validated
	 * @param string $attribute - The name of the attribute to be validated.
	 */
	public function validateAttribute($object, $attribute) {
//		if ($attribute == "id") {
//			return ;
//		}
		if ($this->isEmpty($object->$attribute, true)) {
			$this->error($object, $attribute); return ;
		}
		if (!($object instanceof FormModel)) {
			return ;
		}
		$config = $object->config();
		if (strtolower($config[$attribute]["type"]) == "dropdown" ||
			strtolower($config[$attribute]["type"]) == "multiple"
		) {
			if ($object->$attribute == "-1" || $object->$attribute == -1) {
				$this->error($object, $attribute);
			}
		}
	}

	/**
	 * Add error message for current validation loop
	 * @param mixed|FormModel $object the data object being validated
	 * @param string $attribute the name of the attribute to be validated.
	 */
	protected function error($object, $attribute) {
		$this->addError($object, $attribute, Yii::t("yii", "{attribute} cannot be blank."));
	}
}