<?php

namespace app\forms;

use app\core\FormModel;

class LoginForm extends FormModel {

	public $login;
	public $password;

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return [
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
			"login" => [
				"label" => "Логин",
				"type" => "text",
				"rules" => "required"
			],
			"password" => [
				"label" => "Пароль",
				"type" => "password",
				"rules" => "required"
			]
		];
	}
}