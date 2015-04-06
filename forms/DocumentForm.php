<?php

namespace app\forms;

use app\core\FormModel;
use app\models\Document;

class DocumentForm extends FormModel {

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return Document::getRules([]);
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
				"label" => "Сотрудник",
				"type" => "text",
				"rules" => "required",
				"table" => [
					"name" => "core.employee",
					"format" => "%{surname} %{name} %{patronymic}",
					"key" => "id",
					"value" => "surname, name, patronymic"
				]
			],
			"upload_time" => [
				"label" => "Время загрузки",
				"type" => "text"
			],
			"parent_id" => [
				"label" => "Родитель",
				"type" => "number"
			],
			"type" => [
				"label" => "Тип",
				"type" => "DocumentType",
				"rules" => "required"
			],
			"status" => [
				"label" => "Статус документа",
				"type" => "DocumentStatus",
				"rules" => "required"
			],
			"category_id" => [
				"label" => "Категория",
				"type" => "DropDown",
				"rules" => "required",
				"table" => [
					"name" => "doc.document_category",
					"key" => "id",
					"value" => "name"
				]
			]
		];
	}

	public $id;
	public $name;
	public $path;
	public $employee_id;
	public $upload_time;
	public $parent_id;
	public $type;
	public $status;
	public $category_id;
}