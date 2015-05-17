<?php
/**
 * @var $this \yii\web\View
 * @var $model app\modules\doc\forms\MacroCreateForm
 */
$form = app\widgets\ActiveForm::begin([
    "action" => Yii::$app->getUrlManager()->createUrl("doc/macro/create"),
    "options" => [
        "class" => "doc-macro-create-form",
        "role" => "form"
    ]
]);
print $form->field($model, "name")->textInput();
print $form->field($model, "type")->dropDownList([ 0 => "Нет" ] + \app\models\doc\Macro::listTypes());
print $form->field($model, "table", [
    "options" => [
        "class" => "form-group",
        "style" => "display: none"
    ]
])->dropDownList([ 0 => "Нет" ] + \app\models\doc\Macro::listTables());
print \yii\helpers\Html::tag("div", "", [
    "class" => "macro-multiple-container"
]);
foreach (\app\models\doc\Macro::listTypes() as $key => $type) {
    print $form->field($model, "value", [
        "options" => [
            "class" => "form-group",
            "data-field" => $key,
            "style" => "display: none"
        ]
    ])->renderEx($key, \app\core\TypeManager::getManager()->getField($key));
}
$form->end();