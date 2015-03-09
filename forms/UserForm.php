<?php

namespace app\forms;

use app\core\FormModel;
use app\models\User;

class UserForm extends FormModel {

	public $id;
	public $login;
	public $password;
	public $password2;
	public $email;
	public $register_date;
	public $access_token;

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return User::getRules([
			[ [ "id", "password2", "email" ], "hide", "on" => "login" ],
			[ "id", "hide", "on" => "register" ],
			[ [ "id", "login" ], "hide", "on" => "update" ]
		]);
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
				"type" => "hidden",
				"rules" => "safe"
			],
			"login" => [
				"label" => "Логин",
				"type" => "text",
				"rules" => "required"
			],
			"password" => [
				"label" => "Пароль",
				"type" => "password",
				"rules" => "required"
			],
			"password2" => [
				"label" => "Повторите пароль",
				"type" => "password",
				"rules" => "safe"
			],
			"email" => [
				"label" => "Почтовый ящик",
				"type" => "email",
				"rules" => "email"
			]
		];
	}
}