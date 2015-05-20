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

	public static $allowedTypes = [
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
				"rules" => "mixed"
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
			]
        ];
    }

    public function rules() {
        return [
            [ "type", "string", "max" => 10 ],
            [ "name", "string", "max" => 100 ],
        ];
    }

    public static function tableName() {
        return "doc.macro";
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

	public static function listTypes() {
		return TypeManager::getManager()->listTypes(static::$allowedTypes);
	}
}