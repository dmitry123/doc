<?php

namespace app\modules\doc\grids;

use app\core\GridProvider;
use app\models\doc\Macro;
use app\widgets\ControlMenu;

class EditorMacroGridProvider extends GridProvider {

	public $static = 1;
	public $file = 0;

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
                "icon" => "fa fa-trash font-danger",
				"onclick" => "confirmDelete()"
            ]
        ],
		"mode" => ControlMenu::MODE_ICON,
		"special" => "builder-control-menu-icon"
    ];

	public $menuWidth = 100;

    public function getQuery() {
		if (empty($this->file)) {
			$this->file = \Yii::$app->getRequest()->getQueryParam("file");
		}
        $query = Macro::find()->where("is_static = :static", [
			":static" => $this->static
		]);
		if (!empty($this->file)) {
			$query->andWhere("file_id = :file", [
				":file" => $this->file
			]);
		}
		return $query;
    }
}