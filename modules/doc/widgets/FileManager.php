<?php

namespace app\modules\doc\widgets;

use app\models\doc\FileExt;
use app\modules\doc\core\FileWidget;

class FileManager extends FileWidget {

    public $allowed = [ "document" ];

    public function run() {
        return $this->render("FileManager", [
            "file" => $this->file,
            "ext" => FileExt::findOne([
                "id" => $this->file->{"file_ext_id"}
            ])
        ]);
    }
}