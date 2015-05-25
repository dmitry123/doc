<?php

namespace app\models\doc;

use yii\db\mssql\PDO;

class File extends \app\core\ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "integer"
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

    public static function findCached($ext, $parent) {
        return static::findOne([
            "file_ext_id" => $ext,
            "parent_id" => $parent,
            "file_type_id" => "cached",
            "file_status_id" => "cached"
        ]);
    }

    public static function findMacro($file) {
        $rows = Macro::find()->select("m.*")
            ->from("doc.macro as m")
            ->innerJoin("doc.macro_to_file as m_f", "m.id = m_f.macro_id")
            ->innerJoin("doc.file as f", "m_f.file_id = f.id")
            ->where("f.id = :file_id", [
                ":file_id" => $file
            ])->all();
        return $rows;
    }

	public static function findFileMacro($file, $static = false) {
		$query = FileMacro::find()->select("fm.*, m.*, fm.name as content")
			->from("doc.file_macro as fm")
			->innerJoin("doc.macro as m", "fm.macro_id = m.id")
			->where("fm.file_id = :file", [
				":file" => $file
			]);
		if ($static !== false) {
			$query->andWhere([ "is_static" => $static ]);
		}
		return $query->createCommand()->queryAll(PDO::FETCH_ASSOC);
	}
}