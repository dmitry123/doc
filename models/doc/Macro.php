<?php

namespace app\models\doc;

use app\core\ActiveRecord;
use app\core\PostgreSQL;
use app\core\TableLocalization;
use app\core\TypeManager;
use yii\helpers\ArrayHelper;

class Macro extends ActiveRecord {

    public static $allowedTables = [
        "core.city",
        "core.country",
        "core.department",
        "core.about_employee",
        "core.employee",
        "core.institute",
        "core.phone",
        "core.region",
        "core.role",
        "core.user",
        "core.admin",
        "core.director",
        "core.implementer",
        "core.manager",
        "core.student",
        "core.super",
        "core.teacher",
        "core.tester"
    ];

	public static $allowedStaticTypes = [
		"text",
		"number",
		"boolean",
		"date",
		"time",
		"dropdown",
		"email",
		"phone",
		"textarea",
		"system"
	];

	public static $allowedDynamicTypes = [
		"text",
		"number",
		"boolean",
		"date",
		"time",
		"dropdown",
		"email",
		"phone",
		"textarea",
		"system"
	];

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
            "type" => [
                "label" => "Тип данных",
                "type" => "dropdown",
                "source" => "listTypes",
                "rules" => "required"
            ],
            "value" => [
                "label" => "Значение",
                "type" => "mixed",
				"rules" => "safe"
            ],
			"columns" => [
				"label" => "Столбцы",
				"type" => "text",
				"rules" => "safe"
			],
			"table" => [
				"label" => "Таблица",
				"type" => "dropdown",
				"rules" => "safe"
			],
			"file_id" => [
				"label" => "Файл",
				"type" => "dropdown",
				"table" => [
					"name" => "doc.template",
					"key" => "id",
					"value" => "name"
				],
				"rules" => "safe"
			],
			"is_static" => [
				"label" => "Статический",
				"type" => "boolean",
				"rules" => "safe"
			]
        ];
    }

    public function rules() {
        return [
            [ "type", "string", "max" => 10 ],
            [ "name", "string", "max" => 100 ],
        ];
    }

    public static function listTables() {
        $array = ArrayHelper::map(PostgreSQL::findOrderedAndHashed(static::$allowedTables),
			"hash", "localize"
		);
        uasort($array, function($left, $right) {
            return strcasecmp($left, $right);
        });
        return $array;
    }

	public static function listStaticTypes() {
		return TypeManager::getManager()->listTypes(static::$allowedStaticTypes);
	}

	public static function listDynamicTypes() {
		return TypeManager::getManager()->listTypes(static::$allowedDynamicTypes);
	}

	public static function tableName() {
		return "doc.macro";
	}
}