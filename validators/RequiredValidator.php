<?php

namespace app\validators;

use app\core\Model;
use app\core\TypeManager;
use Yii;
use app\core\FormModel;
use yii\base\Exception;

class RequiredValidator extends \yii\validators\RequiredValidator {

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
		if (TypeManager::getManager()->test("list", $type) && is_scalar($value) && (string) $value === "0") {
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
		if ($type != null && ($b = $this->validateValueEx($type, $model->$attribute, $model)) !== true) {
			if (is_string($b)) {
				$this->addError($model, $attribute, $b);
			} else if (!$b) {
				$this->error($model, $attribute);
			}
		}
	}

	protected function error($object, $attribute) {
		$this->addError($object, $attribute, Yii::t("yii", "Поле \"{attribute}\" должно быть заполнено."));
	}
}