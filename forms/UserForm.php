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
	 * Returns attribute values.
	 * @param array $names list of attributes whose value needs to be returned.
	 * Defaults to null, meaning all attributes listed in [[attributes()]] will be returned.
	 * If it is an array, only the attributes in the array will be returned.
	 * @param array $except list of attributes whose value should NOT be returned.
	 * @return array attribute values (name => value).
	 */
	public function getAttributes($names = null, $except = []) {
		return parent::getAttributes($names, [
			"password2", "register_date", "access_token"
		]);
	}

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return User::getRules([
			[ [ "id", "password2", "email", "access_token" ], "hide", "on" => "login" ],
			[ [ "id", "access_token" ], "hide", "on" => "register" ],
			[ [ "id", "login", "access_token" ], "hide", "on" => "update" ],
			[ [ "register_date" ], "hide", "on" => "register" ],
			[ [ "password", "password2" ], "hide", "on" => "table" ]
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
				"type" => "number"
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
			],
			"register_date" => [
				"label" => "Дата регистрации",
				"type" => "text",
				"rules" => "safe"
			]
		];
	}
}