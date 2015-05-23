<?php

namespace app\modules\doc\grids;

use app\core\GridProvider;
use app\widgets\ControlMenu;
use yii\base\Exception;
use yii\db\ActiveQuery;

class File_TemplateManager_GridProvider extends GridProvider {

    /**
     * @var int file identification number
     */
    public $file = null;

    public $columns = [
        "id" => "#",
        "name" => "Название",
        "upload_date" => "Создан",
        "upload_time" => ""
    ];

    public $menu = [
        "controls" => [
            "template-view-icon" => [
                "label" => "Просмотреть",
                "icon" => "fa fa-book"
            ],
            "template-edit-icon" => [
                "label" => "Редактировать",
                "icon" => "fa fa-edit",
				"href" => "#"
            ],
            "template-remove-icon" => [
                "label" => "Удалить",
                "icon" => "fa fa-trash font-danger",
                "onclick" => "confirmDelete()"
            ],
        ],
        "mode" => ControlMenu::MODE_MENU
    ];

    public $menuAlignment = "right";
    public $fetcher = '\app\models\doc\Template';
    public $menuWidth = 100;
    public $pagination = false;
    public $sort = false;
    public $hasFooter = false;

    /**
     * Override that method to return instance
     * of ActiveQuery class
     *
     * @return ActiveQuery
     * @throws Exception
     */
    public function getQuery() {
        if (empty($this->file)) {
            throw new Exception("File's identification number mustn't be empty");
        }
        return \app\models\doc\Template::find()->where("parent_id = :parent_id and file_status_id = :file_status_id", [
            ":parent_id" => $this->file,
            ":file_status_id" => "new"
        ]);
    }
}