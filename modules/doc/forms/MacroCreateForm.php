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

    public function attributeLabels() {
        return parent::attributeLabels() + [
            "columns" => "Столбцы",
            "table" => "Таблица"
        ];
    }

    public function createActiveRecord() {
        return new Macro();
    }
}