<?php

namespace app\modules\doc\grids;

use app\core\GridProvider;
use app\models\doc\Macro;

class Editor_MacroTable_Grid extends GridProvider {

    public $columns = [
        "id" => [
            "label" => "#",
            "width" => "50px"
        ],
        "type" => [
            "label" => "Тип",
            "width" => "150px"
        ],
        "value" => "Значение"
    ];

    public $sort = [
        "attributes" => [
            "id", "type", "value"
        ],
        "orderBy" => [
            "id" => SORT_DESC
        ],
    ];

    public $menu = [
        "controls" => [
            "macro-edit-button" => [
                "label" => "Изменить",
                "icon" => "fa fa-edit",
            ],
            "macro-delete-button" => [
                "label" => "Удалить",
                "icon" => "fa fa-trash"
            ]
        ]
    ];

    public function getQuery() {
        return Macro::find();
    }
}