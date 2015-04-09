<?php

namespace app\forms;

use app\core\FormModel;
use app\models\File;

class FileForm extends FormModel {

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return File::getRules([
			[ "id", "hide", "on" => "admin.table.register" ],
			[ "id", "hide", "on" => "admin.table.update" ]
		]);
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
				"label" => "Название",
				"type" => "text",
				"rules" => "required"
			],
			"path" => [
				"label" => "Путь",
				"type" => "text"
			],
			"employee_id" => [
				"label" => "Загрузил",
				"type" => "DropDown",
				"table" => [
					"name" => "core.employee",
					"format" => "%{surname} %{name}",
					"key" => "id",
					"value" => "surname, name"
				],
				"rules" => "required",
			],
			"upload_time" => [
				"label" => "Время загрузки",
				"type" => "text"
			],
			"parent_id" => [
				"label" => "Предыдущая версия",
				"type" => "number"
			],
			"status" => [
				"label" => "Статус документа",
				"type" => "DropDown",
				"table" => [
					"name" => "core.file_status",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			],
			"type" => [
				"label" => "Тип",
				"type" => "DropDown",
				"table" => [
					"name" => "core.file_type",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			],
			"mime_type_id" => [
				"label" => "Расширение",
				"type" => "DropDown",
				"table" => [
					"name" => "core.mime_type",
					"key" => "id",
					"value" => "ext"
				],
				"rules" => "required"
			]
		];
	}

	public $id;
	public $name;
	public $path;
	public $employee_id;
	public $upload_time;
	public $parent_id;
	public $status;
	public $type;
	public $mime_type_id;
}