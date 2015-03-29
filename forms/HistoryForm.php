<?php

namespace app\forms;

use app\core\FormModel;
use app\models\History;

class HistoryForm extends FormModel {

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return History::getRules([]);
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
			"original_id" => [
				"label" => "Оригинал документа",
				"type" => "DropDown",
				"table" => [
					"name" => "doc.document",
					"key" => "id",
					"value" => "name"
				],
				"options" => [
					"disabled" => "true"
				],
				"rules" => "required"
			],
			"current_id" => [
				"label" => "Текущий документ",
				"type" => "DropDown",
				"table" => [
					"name" => "doc.document",
					"key" => "id",
					"value" => "name"
				],
				"options" => [
					"disabled" => "true"
				],
				"rules" => "required"
			],
			"employee_id" => [
				"label" => "Сотрудник",
				"type" => "text",
				"options" => [
					"disabled" => "true"
				],
				"table" => [
					"name" => "core.employee",
					"format" => "%{surname} %{name} %{patronymic}",
					"key" => "id",
					"value" => "surname, name, patronymic"
				],
				"rules" => "required"
			],
			"date" => [
				"label" => "Дата изменения",
				"type" => "date",
				"options" => [
					"disabled" => "true"
				],
				"rules" => "required"
			]
		];
	}

	public $id;
	public $original_id;
	public $current_id;
	public $employee_id;
	public $date;
}