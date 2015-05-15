<?php
/**
 * @var $file mixed
 * @var $ext mixed
 */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

print Html::beginTag("div", [
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
            "class" => "btn btn-primary btn-sm",
            "label" => "Создать",
            "icon" => "fa fa-plus"
        ]
    ],
    "bodyClass" => "panel-body clear"
]);
\app\widgets\Panel::begin([
    "title" => "Выгрузка файла",
    "upgradeable" => false
]) ?>
<div class="col-xs-6">
<?= Html::dropDownList("ext", $ext->id,
    ArrayHelper::map(\app\models\doc\FileExt::find()->all(), "id", "ext"), [
        "class" => "form-control"
    ]
) ?>
</div>
<div class="col-xs-6">
<?= \app\widgets\ControlMenu::widget([
    "controls" => [
        "file-template-manager-download-button" => [
            "class" => "btn btn-success btn-block",
            "label" => "Скачать",
            "icon" => "fa fa-download"
        ]
    ],
    "mode" => \app\widgets\ControlMenu::MODE_BUTTON
]) ?>
</div>
<iframe class="download-frame" style="display: none"></iframe>
<?php \app\widgets\Panel::end();
print Html::endTag("div");