<?php

namespace app\validators;

use yii\validators\Validator;

class CryptValidator extends Validator {

	/**
	 * Validates a single attribute.
	 * Child classes must implement this method to provide the actual validation logic.
	 * @param \yii\base\Model $model the data model to be validated
	 * @param string $attribute the name of the attribute to be validated.
	 */
	public function validateAttribute($model, $attribute) {
		$model->$attribute = \Yii::$app->getSecurity()->generatePasswordHash($model->$attribute);
	}
}