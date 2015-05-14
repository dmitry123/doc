<?php

namespace app\fields;

use app\core\Field;
use app\core\FormModel;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

class MultipleField extends Field {

	/**
	 * Override that method to render field base on it's type
	 * @param ActiveForm $form - Form
	 * @param FormModel $model - Model
	 * @return ActiveField - Just rendered field result
	 */
	public function render($form, $model) {
		return $form->field($model, $this->getKey())->dropDownList($this->getData(), $this->getOptions([
			'class' => 'form-control',
			'onchange' => "DropDown && DropDown.change && DropDown.change.call(this)",
			'options' => [ $this->getValue() => [ 'selected' => true ] ],
			'multiple' => true
		]));
	}

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public function key() {
		return "Multiple";
	}

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public function name() {
		return "Множественный выбор";
	}
}

/*
	$multiple = true;
	$data = $this->getData();
	if (!$multiple) {
		if (!isset($data[-1]) && !$this->getValue()) {
			$data = [ -1 => "Нет" ] + $data;
		}
	}
	$content = CHtml::openTag("div", [
		"class" => "multiple"
	]);
	$content .=  $form->dropDownList($model, $this->getKey(), $data, [
		'placeholder' => $this->getLabel(),
		'id' => $this->getKey(),
		'class' => 'form-control',
		'value' => $this->getValue(),
		'options' => [ $this->getValue() => [ 'selected' => true ] ],
		'multiple' => $multiple
	]);
	$content .= CHtml::tag("div", [
		"class" => "multiple-container form-control"
	], "", true);
	return $content.CHtml::closeTag("div");
*/