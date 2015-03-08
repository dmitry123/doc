<?php

namespace app\fields;

use app\core\Field;
use app\core\FormModel;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class DateField extends Field {

	/**
	 * Override that method to render field base on it's type
	 * @param ActiveForm $form - Form
	 * @param FormModel $model - Model
	 * @return ActiveField - Just rendered field result
	 */
	public function render($form, $model) {
		$form->field($model, $this->getKey())->input("date", $this->getOptions([
			'class' => 'form-control',
			'value' => $this->getValue()
		]));
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "Date";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Дата";
	}
}