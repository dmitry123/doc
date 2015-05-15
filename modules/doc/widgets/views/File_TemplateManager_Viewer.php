<?php
/**
 * @var $file mixed
 */
print \yii\helpers\Html::beginTag("div", [
    "class" => "template-manager-viewer"
]);
print \app\widgets\Panel::widget([
    "title" => "Список шаблонов",
    "body" => \app\widgets\Grid::create([
        "provider" => new \app\modules\doc\grids\File_TemplateManager_GridProvider([
            "file" => $file->{"id"}
        ])
    ]),
    "controls" => [
        "panel-update-button" => [
            "class" => "btn btn-default btn-sm",
            "label" => "Обновить",
            "icon" => "glyphicon glyphicon-refresh",
            "onclick" => "$(this).panel('update')",
        ],
        "create-template-button" => [
            "class" => "btn btn-success btn-sm",
            "label" => "Создать",
            "icon" => "fa fa-plus"
        ]
    ],
    "bodyClass" => "panel-body clear"
]);
print \yii\helpers\Html::endTag("div");