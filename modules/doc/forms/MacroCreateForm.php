<?php

namespace app\modules\doc\forms;

use app\core\FormModel;
use app\models\doc\Macro;

class MacroCreateForm extends FormModel {

    public $name;
    public $type;
    public $value;

    public function createActiveRecord() {
        return new Macro();
    }
}