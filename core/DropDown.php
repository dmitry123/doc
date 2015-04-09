<?php

namespace app\core;

use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

abstract class DropDown extends Field {

	/**
	 * Override that method to get current field instance
	 * @param string $class - Name of field's class
	 * @return DropDown - Field object
	 */
	public static function field($class = null) {
		return parent::field($class);
	}

	/**
     * Override that method to return associative array
     * for drop down list
     * @return array - Array with data
     */
    public abstract function data();

	/**
	 * Get some drop down list option by it's key
	 * @param string $key - Data key to get
	 * @return mixed - Value
	 */
	public function getOption($key) {
		$data = $this->getData();
		if (isset($data[$key])) {
			return $data[$key];
		} else {
			return null;
		}
	}

	/**
	 * Get cached array with drop down list data
	 * @param mixed $value - Get by it's key
	 * @return array - Array with drop down list
	 */
	public function getData($value = null) {
		if ($this->data == null && ($this->data = $this->data()) != null) {
			if (!$this->isBoolean() && !isset($this->data[0])) {
				$this->data[0] = "Не выбрано";
			}
		 } else if ($this->data() == null) {
			$this->data = [];
		}
		if ($value !== null) {
			return isset($this->data[$value]) ? $this->data[$value] : null;
		}
		return $this->data;
	}

	private $data = null;

	/**
	 * Render drop down list as radio button list
	 * @param ActiveForm $form - Form widget with renderer
	 * @param FormModel $model - Form model with fields configuration
	 * @return ActiveField - Active field to render
	 */
	public function renderAsRadio($form, $model) {
		return $form->field($model, $this->getKey())->radioList($this->getData(), $this->getOptions([
			'value' => $this->getValue(),
			'class' => 'form-control'
		]));
	}

	/**
	 * Render drop down list as checkbox list
	 * @param ActiveForm $form - Form widget with renderer
	 * @param FormModel $model - Form model with fields configuration
	 * @return ActiveField - Active field to render
	 */
	public function renderAsCheckbox($form, $model) {
		return $form->field($model, $this->getKey())->checkboxList($this->getData(), $this->getOptions([
			'value' => $this->getValue(),
			'class' => 'form-control'
		]));
	}

	/**
	 * Override that method to render field base on it's type
	 * @param ActiveForm $form - Form
	 * @param FormModel $model - Model
	 * @return ActiveField - Just rendered field result
	 */
	public final function render($form, $model) {
		return $form->field($model, $this->getKey())->dropDownList($this->getData(), $this->getOptions([
			'options' => [ $this->getValue() => [ 'selected' => true ] ],
			'class' => 'form-control'
		]));
	}

	/**
	 * Override that method to make that field as boolean type
	 * @return bool - True, if your subtype is boolean like
	 */
	public function isBoolean() {
		return false;
	}
}