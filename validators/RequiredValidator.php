<?php

namespace app\validators;

use Yii;
use app\core\FormModel;

class RequiredValidator extends \yii\validators\RequiredValidator {

	public static function validateValueEx($type, $value, $model = null) {
		if (in_array($type, [ "dropdown", "multiple" ]) && is_scalar($value) && (string) $value === "0") {
			return false;
		} else {
			return true;
		}
	}

	public function init() {
		parent::init();
		$this->message = $this->requiredValue === null ? Yii::t("yii", "Поле \"{attribute}\" должно быть заполнено.")
			: Yii::t("yii", "{attribute} must be \"{requiredValue}\".");
	}

	public function validateAttribute($model, $attribute) {
		parent::validateAttribute($model, $attribute);
		if ($model instanceof FormModel) {
			$type = $model->getActiveRecord()->getManager()->getType($attribute);
		} else {
			$type = null;
		}
		if ($type != null && !$this->validateValueEx($type, $model->$attribute, $model)) {
			$this->error($model, $attribute);
		}
	}

	protected function error($object, $attribute) {
		$this->addError($object, $attribute, Yii::t("yii", "Поле \"{attribute}\" должно быть заполнено."));
	}
}