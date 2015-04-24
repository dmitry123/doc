<?php

namespace app\forms;

use app\core\FormModel;

class MimeTypeForm extends FormModel {

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
			"mime" => [
				"label" => "Тип",
				"type" => "text"
			],
			"ext" => [
				"label" => "Расширение",
				"type" => "text"
			]
		];
	}

	public $id;
	public $mime;
	public $ext;
}