<?php

namespace app\models\doc;

use app\core\ActiveRecord;
use app\core\TypeManager;

class Macro extends ActiveRecord {

    public function configure() {
        return [
            "id" => [
                "label" => "Идентификатор",
                "type" => "hidden",
                "rules" => "numerical"
            ],
            "type" => [
                "label" => "Тип данных",
                "type" => "dropdown",
                "source" => "listTypes",
                "rules" => "required"
            ],
            "value" => [
                "label" => "Значение",
                "type" => "text"
            ]
        ];
    }

    public function rules() {
        return [
            [ "type", "string", "max" => 10 ]
        ];
    }

    public static function tableName() {
        return "doc.macro";
    }

    public static function listTypes() {
        return TypeManager::getManager()->listTypes();
    }
}