<?php

namespace app\fields;

use app\core\Field;
use app\core\FormModel;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class DropDownField extends Field {

	/**
	 * Override that method to render field base on it's type
	 * @param ActiveForm $form - Form
	 * @param FormModel $model - Model
	 * @return ActiveField - Just rendered field result
	 */
	public function render($form, $model) {
		return $form->field($model, $this->getKey())->dropDownList($this->getData(), $this->getOptions([
			'onchange' => "DropDown && DropDown.change && DropDown.change.call(this)",
			'class' => 'form-control',
			'options' => [ $this->getValue() => [ 'selected' => true ] ]
		]));
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "DropDown";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Выпадающий список";
	}
}