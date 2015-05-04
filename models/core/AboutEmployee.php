<?php

namespace app\models\core;

use app\core\ViewTrait;

class AboutEmployee extends Employee {

	use ViewTrait;

	public function configure() {
		return parent::configure() + [
			"email" => [
				"label" => "Почтовый ящик",
				"type" => "email",
				"rules" => "email"
			],
			"login" => [
				"label" => "Логин",
				"type" => "text",
				"rules" => "required"
			],
			"role_name" => [
				"label" => "Наименование роли",
				"type" => "text",
				"rules" => "required"
			],
			"role_description" => [
				"label" => "Описание роли",
				"type" => "text",
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return parent::rules() + [
			[ [ "email", "login" ], "string", "max" => 50 ],
			[ "role_name", "string", "max" => 100 ]
		];
	}

	public static function tableName() {
		return "core.about_employee";
	}
}