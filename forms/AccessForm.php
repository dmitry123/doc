<?php

namespace app\forms;

use app\core\FormModel;

class AccessForm extends FormModel {

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
				"type" => "hidden"
			],
			"privilege_id" => [
				"label" => "Привилегия",
				"type" => "DropDown",
				"table" => [
					"name" => "core.privilege",
					"key" => "id",
					"value" => "name"
				]
			],
			"role_id" => [
				"label" => "Роль",
				"type" => "DropDown",
				"table" => [
					"name" => "core.role",
					"key" => "id",
					"value" => "name"
				]
			],
			"department_id" => [
				"label" => "Кафедра",
				"type" => "DropDown",
				"table" => [
					"name" => "core.department",
					"key" => "id",
					"value" => "name"
				]
			],
			"institute_id" => [
				"label" => "Институт",
				"type" => "DropDown",
				"table" => [
					"name" => "core.institute",
					"key" => "id",
					"value" => "name"
				]
			],
			"file_id" => [
				"label" => "Файл",
				"type" => "DropDown",
				"table" => [
					"name" => "core.file",
					"key" => "id",
					"value" => "name"
				]
			],
			"mode" => [
				"label" => "Режим",
				"type" => "AccessMode",
				"rules" => "required"
			]
		];
	}

	public $id;
	public $privilege_id;
	public $role_id;
	public $department_id;
	public $institute_id;
	public $file_id;
	public $mode;
}