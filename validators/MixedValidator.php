<?php

namespace app\validators;

use yii\base\Exception;

class MixedValidator extends RequiredValidator {

	public static function validateValueEx($type, $value, $model = null) {
		if (!in_array($type, [ "mixed" ]) || !is_array($value)) {
			return false;
		}
		if (!isset($model->{"type"}) || empty($model->{"type"})) {
			throw new Exception("MixedValidator requires form model's not empty [type] field");
		}
		return parent::validateValueEx($model->{"type"}, $value[$model->{"type"}]);
	}
}