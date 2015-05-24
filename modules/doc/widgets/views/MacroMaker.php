<?php
/**
 * @var $this \yii\web\View
 * @var $model app\modules\doc\forms\MacroForm
 */
$form = app\widgets\ActiveForm::begin([
    "action" => Yii::$app->getUrlManager()->createUrl("doc/macro/new"),
    "options" => [
        "class" => "doc-macro-create-form",
        "role" => "form"
    ]
]);
print $form->field($model, "name")->textInput();
print $form->field($model, "type")->dropDownList([ 0 => "Нет" ] + \app\models\doc\Macro::listStaticTypes());
print $form->field($model, "table", [
    "options" => [
        "class" => "form-group",
        "style" => "display: none"
    ]
])->dropDownList([ 0 => "Нет" ] + \app\models\doc\Macro::listTables());
print $form->field($model, "columns", [
	"options" => [
		"class" => "form-group",
		"style" => "display: none"
	]
])->multipleInput([
	"name" => ""
]);
foreach (\app\models\doc\Macro::listStaticTypes() as $key => $type) {
    print $form->field($model, "value", [
        "options" => [
            "class" => "form-group",
            "data-field" => $key,
            "style" => "display: none"
        ]
    ])->renderEx($key, \app\core\TypeManager::getManager()->getField($key), [
		"name" => "MacroForm[value][$key]"
	]);
}
print $form->field($model, "is_static", [
	"options" => [
		"class" => "form-group",
		"style" => "display: none"
	]
])->hiddenInput([
	"data-cleanup" => "false"
]);
print $form->field($model, "file_id", [
	"options" => [
		"class" => "form-group",
		"style" => "display: none"
	]
])->hiddenInput([
	"data-cleanup" => "false"
]);
$form->end();