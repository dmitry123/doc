<?php

namespace app\fields;

use app\core\Field;
use app\core\FormModel;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class PhoneField extends Field {

	/**
	 * Override that method to render field base on it's type
	 * @param ActiveForm $form - Form
	 * @param FormModel $model - Model
	 * @return ActiveField - Just rendered field result
	 */
	public function render($form, $model) {
		return $form->field($model, $this->getKey())->textInput($this->getOptions([
			'placeholder' => '+7 (xxx) xxx xx xx',
			'data-regexp' => '^\\+\\s*[1-9]\\s*\\([0-9\\s]{3}\s\\)\\s*[0-9]{3}\\s[0-9]{2}\\s[0-9]{2}\\s',
			'class' => 'form-control',
			'value' => $this->getValue()
		]));
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "Phone";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Телефон";
	}
}