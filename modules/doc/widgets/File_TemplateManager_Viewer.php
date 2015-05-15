<?php

namespace app\modules\doc\widgets;

use app\models\doc\FileExt;
use app\modules\doc\core\FileWidget;

class File_TemplateManager_Viewer extends FileWidget {

    public $allowed = [ "document" ];

    public function run() {
        return $this->render("File_TemplateManager_Viewer", [
            "file" => $this->file,
            "ext" => FileExt::findOne([
                "id" => $this->file->{"file_ext_id"}
            ])
        ]);
    }
}