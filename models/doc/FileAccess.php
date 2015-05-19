<?php

namespace app\models\doc;

use app\core\ActiveRecord;

class FileAccess extends ActiveRecord {

	const MODE_DENIED  = 0x00;
	const MODE_READ    = 0x01;
	const MODE_WRITE   = 0x02;
	const MODE_ALLOWED = 0xff;

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "integer"
			],
			"mode" => [
				"label" => "Режим",
				"type" => "DropDown",
				"source" => "listModes",
				"rules" => "required"
			],
			"file_id" => [
				"label" => "Файл",
				"type" => "DropDown",
				"table" => [
					"name" => "doc.file",
					"key" => "id",
					"value" => "name"
				]
			],
			"file_category_id" => [
				"label" => "Категория файла",
				"type" => "DropDown",
				"table" => [
					"name" => "doc.file_category",
					"key" => "id",
					"value" => "name"
				]
			],
			"privilege_id" => [
				"label" => "Привилегия",
				"type" => "DropDown",
				"table" => [
					"name" => "core.privilege",
					"key" => "id",
					"value" => "name"
				]
			],
			"role_id" => [
				"label" => "Роль",
				"type" => "DropDown",
				"table" => [
					"name" => "core.role",
					"key" => "id",
					"value" => "name"
				]
			],
			"department_id" => [
				"label" => "Кафедра",
				"type" => "DropDown",
				"table" => [
					"name" => "core.department",
					"key" => "id",
					"value" => "name"
				]
			],
			"institute_id" => [
				"label" => "Институт",
				"type" => "DropDown",
				"table" => [
					"name" => "core.institute",
					"key" => "id",
					"value" => "name"
				]
			],
			"employee_id" => [
				"label" => "Сотрудник",
				"type" => "DropDown",
				"table" => [
					"name" => "core.about_employee",
					"key" => "id",
					"format" => "%{surname} %{name} %{patronymic} (%{role_name})",
					"value" => "surname, name, patronymic, role_name"
				]
			],
		];
	}

	public function rules() {
		return [
			[ "privilege_id", "string", "max" => 10 ],
			[ "role_id", "string", "max" => 20 ]
		];
	}

	public static function tableName() {
		return "doc.file_access";
	}

	/**
	 * List array with access mode and it's labels
	 * @return array with access mode items
	 */
	public static function listModes() {
		return [
			FileAccess::MODE_DENIED => "Запрещен",
			FileAccess::MODE_READ => "Чтение",
			FileAccess::MODE_WRITE => "Запись",
			FileAccess::MODE_ALLOWED => "Разрешен"
		];
	}
}