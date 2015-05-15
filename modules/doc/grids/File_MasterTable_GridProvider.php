<?php

namespace app\modules\doc\grids;

use app\core\GridProvider;
use app\models\doc\File;
use yii\db\ActiveQuery;

class File_MasterTable_GridProvider extends GridProvider{

    /**
     * Override that method to return instance
     * of ActiveQuery class
     *
     * @return ActiveQuery
     */
    public function getQuery() {
        return File::find();
    }
}