<?php

namespace app\validators;

use app\core\FormModel;
use Yii;
use yii\validators\ValidationAsset;

class RequiredValidator extends \yii\validators\RequiredValidator {

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		$this->message = $this->requiredValue === null ? Yii::t('yii', 'Поле \"{attribute}\" должно быть заполнено.')
			: Yii::t('yii', '{attribute} must be "{requiredValue}".');
	}

	/**
	 * Validates a single attribute. This method should be overridden by child classes.
	 * @param mixed|FormModel $object - The data object being validated
	 * @param string $attribute - The name of the attribute to be validated.
	 */
	public function validateAttribute($object, $attribute) {
		/* if ($attribute == "id") {
			return ;
		} */
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
		$this->addError($object, $attribute, Yii::t("yii", "Поле \"{attribute}\" должно быть заполнено."));
	}

	/**
	 * @inheritdoc
	 */
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