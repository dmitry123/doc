<?php

namespace app\models\doc;

class File extends \app\components\ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "numerical"
			],
			"name" => [
				"label" => "Название",
				"type" => "text",
				"rules" => "required"
			],
			"path" => [
				"label" => "Путь к файлу",
				"type" => "text",
				"rules" => "required"
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
			"employee_id" => [
				"label" => "Загрузил",
				"type" => "DropDown",
				"table" => [
					"name" => "core.employee",
					"format" => "%{surname} %{name}",
					"key" => "id",
					"value" => "surname, name"
				],
				"rules" => "required",
			],
			"upload_time" => [
				"label" => "Время загрузки",
				"type" => "time",
				"attributes" => [
					"readonly" => "true"
				],
				"rules" => "required"
			],
			"upload_date" => [
				"label" => "Дата загрузки",
				"type" => "date",
				"attributes" => [
					"readonly" => "true"
				],
				"rules" => "required"
			],
			"mime_type" => [
				"label" => "MIME тип",
				"type" => "text",
				"rules" => "required"
			],
			"parent_id" => [
				"label" => "Предыдущая версия",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.file",
					"key" => "id",
					"format" => "%{name} (%{upload_date})",
					"value" => "name, upload_date"
				]
			],
			"file_status_id" => [
				"label" => "Статус файла",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.file_status",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			],
			"file_type_id" => [
				"label" => "Тип файла",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.file_type",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "required"
			],
			"file_ext_id" => [
				"label" => "Расширение файла",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.file_ext",
					"key" => "id",
					"value" => "ext"
				],
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return [
			[ [ "file_status_id", "file_type_id" ], "string", "max" => 10 ]
		];
	}

	public static function tableName() {
		return "doc.file";
	}

	public static function getMainTableProvider($fileType) {
		return static::createTableProvider(static::find()
			->select("*")
			->from("doc.file as f")
			->where("f.file_type_id = :file_type_id", [
				":file_type_id" => $fileType
			])
		);
	}
}