<?php

namespace app\modules\doc\forms;

use app\core\FormModel;
use app\models\doc\Macro;

class MacroCreateForm extends FormModel {

    public $name;
    public $type;
    public $table;
    public $columns;
    public $value;

	public function configure() {
		return [
			"table" => [
				"label" => "Таблица",
				"type" => "dropdown",
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return parent::rules() + [
			[ "table", "required" ]
		];
	}

	public function attributeLabels() {
        return parent::attributeLabels() + [
            "columns" => "Столбцы"
        ];
    }

    public function createActiveRecord() {
        return new Macro();
    }
}