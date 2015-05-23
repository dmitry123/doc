<?php

namespace app\modules\doc\grids;

use app\core\GridProvider;
use app\models\doc\Macro;
use app\widgets\ControlMenu;

class EditorMacroGridProvider extends GridProvider {

    public $columns = [
        "id" => [
            "label" => "#",
            "width" => "50px"
        ],
        "name" => [
            "label" => "Название",
            "width" => "200px"
        ],
        "type" => [
            "label" => "Тип",
            "width" => "150px"
        ]
    ];

    public $sort = [
        "attributes" => [
            "id", "type", "name"
        ],
        "orderBy" => [
            "id" => SORT_DESC
        ],
    ];

    public $menu = [
        "controls" => [
            "macro-edit-button" => [
                "label" => "Изменить",
                "icon" => "fa fa-pencil",
            ],
            "macro-delete-button" => [
                "label" => "Удалить",
                "icon" => "fa fa-trash font-danger"
            ]
        ],
		"mode" => ControlMenu::MODE_MENU
    ];

    public function getQuery() {
        return Macro::find();
    }
}