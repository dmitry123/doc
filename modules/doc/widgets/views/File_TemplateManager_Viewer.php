<?php
/**
 * @var $file mixed
 */
print \yii\helpers\Html::beginTag("div", [
    "class" => "template-manager-viewer"
]);
\app\widgets\Panel::begin([
    "title" => "Список шаблонов",
    "controls" => [
        "create-template-button" => [
            "class" => "btn btn-success btn-sm",
            "label" => "Создать",
            "icon" => "fa fa-plus"
        ]
    ],
    "bodyClass" => "panel-body clear"
]);
print \app\widgets\Grid::widget([
    "provider" => new \app\core\GridProviderEx([
        "query" => \app\models\doc\Template::find()->where("parent_id = :parent_id", [
            ":parent_id" => $file->{"id"}
        ]),
        "columns" => [
            "id" => "#",
            "name" => "Название",
            "file_ext_id" => "Расширение",
            "upload_date" => "Дата"
        ],
        "menu" => [
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
            "special" => "template-table-control",
        ],
        "menuWidth" => 100,
        "hasHeader" => true,
        "fetcher" => \app\models\doc\Template::className()
    ])
]);
\app\widgets\Panel::end();
print \yii\helpers\Html::endTag("div");