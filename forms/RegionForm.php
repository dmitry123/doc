<?php

namespace app\forms;

use app\core\FormModel;

class RegionForm extends FormModel {

	public $id;
	public $name;
	public $country_id;

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
			"name" => [
				"label" => "Название",
				"type" => "text",
				"rules" => "required"
			],
			"country_id" => [
				"label" => "Страна",
				"type" => "DropDown",
				"table" => [
					"name" => "core.country",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			]
		];
	}
}