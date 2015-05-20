<?php

namespace app\modules\doc\widgets;

use app\core\Widget;
use app\modules\doc\forms\MacroForm;

class MacroMaker extends Widget {

    public function run() {
        return $this->render("MacroMaker", [
            "model" => new MacroForm()
        ]);
    }
}