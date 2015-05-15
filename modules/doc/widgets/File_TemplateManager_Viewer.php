<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileWidget;

class File_TemplateManager_Viewer extends FileWidget {

    public $allowed = [ "document" ];

    public function run() {
        return $this->render("File_TemplateManager_Viewer", [
            "file" => $this->file
        ]);
    }
}