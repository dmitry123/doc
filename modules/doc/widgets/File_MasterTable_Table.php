<?php

namespace app\modules\doc\widgets;

use app\core\Widget;

class File_MasterTable_Table extends Widget {

    /**
     * @var array with configuration for ControlMenu
     *  class or another one
     *
     * @see ControlMenu
     */
    public $controls = [
    ];

    /**
     * @return string content of just rendered widget
     */
    public function run() {
        return $this->render("File_MasterTable_Table", [
            "controls" => $this->controls
        ]);
    }
}