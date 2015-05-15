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
        "file_ext_id" => "Расширение",
        "upload_date" => "Дата"
    ];

    public $menu = [
        "controls" => [
            "template-view-icon" => [
                "label" => "Просмотреть",
                "icon" => "glyphicon glyphicon-ok"
            ],
            "template-edit-icon" => [
                "label" => "Редактировать",
                "icon" => "glyphicon glyphicon-pencil"
            ],
            "template-remove-icon" => [
                "label" => "Удалить",
                "icon" => "glyphicon glyphicon-remove font-danger",
                "onclick" => "confirmDelete()"
            ],
        ],
        "mode" => ControlMenu::MODE_ICON,
        "special" => "template-table-control",
    ];

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