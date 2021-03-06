<?php

namespace app\validators;

use app\core\Model;
use app\core\TypeManager;
use yii\base\Exception;

class MixedValidator extends RequiredValidator {

	public $skipOnEmpty = true;
	public $skipOnError = true;

	/**
	 * Validate value for required rule, even if it has dropdown
	 * or multiple types, that method also uses by subclasses
	 *
	 * @param $type string name of value's type
	 * @param $value mixed value to be validated
	 * @param $model Model instance of form model
	 *
	 * @return bool true of success validation
	 */
	public static function validateValueEx($type, $value, $model = null) {
		if (!in_array($type, [ 'mixed' ]) || !is_array($value)) {
			return false;
		} else if (!isset($model->{'type'}) || empty($model->{'type'})) {
			throw new \InvalidArgumentException('MixedValidator requires form model\'s not empty [type] field');
		} else {
			$value = $value[$model->{'type'}];
		}
		$validator = TypeManager::getManager()->getValidator(
			$model->{'type'}, $model, $model->attributes
		);
		if ($validator != null && ($r = $validator->validate($value, $error)) != true) {
			return $error;
		}
		return parent::validateValueEx($model->{'type'}, $value);
	}
}