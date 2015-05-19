<?php

namespace app\validators;

use Yii;
use app\core\FormModel;
use yii\validators\ValidationAsset;

class RequiredValidator extends \yii\validators\RequiredValidator {

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
		if (in_array($type, [ "dropdown", "multiple" ]) && is_scalar($model->$attribute) && (string) $model->$attribute === "0") {
			$this->error($model, $attribute);
		}
	}

	protected function error($object, $attribute) {
		$this->addError($object, $attribute, Yii::t("yii", "Поле \"{attribute}\" должно быть заполнено."));
	}

	public function clientValidateAttribute($model, $attribute, $view) {
		$options = [];
		if ($this->requiredValue !== null) {
			$options['message'] = Yii::$app->getI18n()->format($this->message, [
				'requiredValue' => $this->requiredValue,
			], Yii::$app->language);
			$options['requiredValue'] = $this->requiredValue;
		} else {
			$options['message'] = $this->message;
		}
		if ($this->strict) {
			$options['strict'] = 1;
		}
		$options['message'] = Yii::$app->getI18n()->format($options['message'], [
			'attribute' => $model->getAttributeLabel($attribute),
		], Yii::$app->language);
		ValidationAsset::register($view);
		return 'yii.validation.required(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
	}
}