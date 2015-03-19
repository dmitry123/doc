<?php

namespace app\forms;

use app\core\FormModel;
use app\models\Phone;

class PhoneForm extends FormModel {

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return Phone::getRules([
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
			"phone" => [
				"label" => "Телефон",
				"type" => "phone",
				"rules" => "required"
			],
			"type" => [
				"label" => "Тип телефона",
				"type" => "PhoneType",
				"rules" => "required"
			]
		];
	}

	public $id;
	public $phone;
	public $type;
}