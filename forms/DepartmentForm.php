<?php

namespace app\forms;

use app\core\FormModel;
use app\models\Department;

class DepartmentForm extends FormModel {

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return Department::getRules([]);
	}

	/**
	 * Override that method to return config. Config should return array associated with
	 * model's variables. Every field must contains 3 parameters:
	 *  + label - Variable's label, will be displayed in the form
	 *  + type - Input type (@see Form::renderField())
	 *  + rules - Basic form's Yii rules, such as 'required' or 'numeric' etc
	 * @return Array - Model's config
	 */
	public function config() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "number"
			],
			"name" => [
				"label" => "Наименование",
				"type" => "text",
				"rules" => "required"
			],
			"institute_id" => [
				"label" => "Институт",
				"type" => "DropDown",
				"table" => [
					"name" => "institute",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			],
			"manager_id" => [
				"label" => "Заведующий",
				"type" => "DropDown",
				"table" => [
					"name" => "employee",
					"format" => "%{surname} %{name} %{patronymic}",
					"key" => "id",
					"value" => "surname, name, patronymic"
				],
				"rules" => "required"
			]
		];
	}

	public $id;
	public $name;
	public $institute_id;
	public $manager_id;
}