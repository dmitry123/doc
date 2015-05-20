<?php

namespace app\modules\doc\forms;

use app\core\FormModel;
use app\models\doc\Macro;
use yii\helpers\ArrayHelper;

class MacroForm extends FormModel {

    public $name;
    public $type;
    public $table;
    public $columns;
    public $value;

	public function configure() {
		return [
			"table" => [
				"label" => "Таблица",
				"type" => "dropdown"
			]
		];
	}

	public function rules() {
		return ArrayHelper::merge(parent::rules(), [
			[ "table", "required", "when" => function($model) {
				return $model->type == "dropdown";
			} ],
			[ "columns", "required", "when" => function($model) {
				return is_scalar($model->table) && (string) $model->table != "0";
			} ]
		]);
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