<?php

namespace app\models\core;

use app\components\ActiveRecord;

class Employee extends ActiveRecord {

	public $login;

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "numerical"
			],
			"surname" => [
				"label" => "Фамилия",
				"type" => "text",
				"rules" => "required"
			],
			"name" => [
				"label" => "Имя",
				"type" => "text",
				"rules" => "required"
			],
			"patronymic" => [
				"label" => "Отчество",
				"type" => "text",
				"rules" => "required"
			],
			"role_id" => [
				"label" => "Роль",
				"type" => "DropDown",
				"table" => [
					"name" => "core.role",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required",
			],
			"user_id" => [
				"label" => "Пользователь",
				"type" => "DropDown",
				"table" => [
					"name" => "core.user",
					"key" => "id",
					"value" => "login"
				],
				"rules" => "required",
			],
			"department_id" => [
				"label" => "Кафедра",
				"type" => "DropDown",
				"table" => [
					"name" => "core.department",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required",
			],
			"phone_id" => [
				"label" => "Телефон",
				"type" => "DropDown",
				"table" => [
					"name" => "core.phone",
					"key" => "id",
					"format" => "+%{region} (%{code}) %{phone}",
					"values" => "region, code, phone"
				],
				"rules" => "required"
			],
			"is_validated" => [
				"label" => "Подтвержден?",
				"type" => "Boolean",
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return [
			[ [ "surname", "patronymic" ], "string", "max" => 100 ],
			[ "name", "string", "max" => 50 ],
			[ "role_id", "string", "max" => 20 ]
		];
	}

	public static function tableName() {
		return "core.employee";
	}
}