<?php

namespace app\forms;

use app\core\FormModel;
use app\models\Log;

class LogForm extends FormModel {

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return Log::getRules([]);
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
			"user_id" => [
				"label" => "Пользователь",
				"type" => "DropDown",
				"table" => [
					"name" => "user",
					"key" => "id",
					"value" => "login"
				],
				"rules" => "required"
			],
			"date" => [
				"label" => "Дата",
				"type" => "date"
			],
			"elapsed_time" => [
				"label" => "Время исполнения",
				"type" => "number"
			],
			"type" => [
				"label" => "Тип действия",
				"type" => "LogAction",
				"rules" => "required"
			]
		];
	}

	public $id;
	public $user_id;
	public $date;
	public $elapsed_time;
	public $type;
}