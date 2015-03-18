<?php

namespace app\forms;

use app\core\FormModel;

class EmployeeForm extends FormModel {

	public $id;
	public $surname;
	public $name;
	public $patronymic;
	public $role_id;
	public $user_id;
	public $department_id;
	public $phone_id;

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return [
			[ "user_id", "default", "value" => \Yii::$app->getUser()->{"id"} ]
		];
	}

	/**
	 * Override that method to return config. Config should return array associated with
	 * model's variables. Every field must contains 3 parameters:
	 *  + label - Variable's label, will be displayed in the form
	 *  + type - Input type (@see _LFormInternalRender#render())
	 *  + rules - Basic form's Yii rules, such as 'required' or 'numeric' etc
	 * @return Array - Model's config
	 */
	public function config() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "number",
				"hidden" => "true"
			],
			"surname" => [
				"label" => "Фамилия",
				"type" => "text",
				"rules" => "required"
			],
			"name" => [
				"label" => "Имя",
				"type" => "text",
				"rules" => "required"
			],
			"patronymic" => [
				"label" => "Отчество",
				"type" => "text",
				"rules" => "required"
			],
			"role_id" => [
				"label" => "Роль",
				"type" => "DropDown",
				"rules" => "required",
				"table" => [
					"name" => "role",
					"key" => "id",
					"value" => "name"
				]
			],
			"user_id" => [
				"label" => "Пользователь",
				"type" => "number",
				"rules" => "required"
			],
			"department_id" => [
				"label" => "Кафедра",
				"type" => "DropDown",
				"rules" => "required",
				"table" => [
					"name" => "department",
					"key" => "id",
					"value" => "name"
				]
			],
			"phone_id" => [
				"label" => "Телефон",
				"type" => "number",
				"rules" => "required"
			]
		];
	}
}