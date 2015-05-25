<?php
/**
 * @var $file app\models\doc\File
 * @var $content string
 * @var $list array
 * @var $model DynamicModel
 */

use yii\base\DynamicModel;

$form = \app\widgets\ActiveForm::begin([
	"action" => Yii::$app->getUrlManager()->createUrl([ "doc/builder/build" ])
]);

print $form->field($model, "name")->label("Название документа")->textInput();

print "<hr>";

print $form->field($model, "file_id", [
	"options" => [
		"class" => "form-group",
		"style" => "display: none"
	]
])->hiddenInput();

foreach ($list as $m) {
	if (!$m["is_static"]) {
		print $form->field($model, $m["id"])->label($m["name"])->renderEx(
			$m["type"], \app\core\TypeManager::getManager()->getField($m["type"])
		);
	} else {
		print $form->field($model, $m["id"])->label($m["name"])->textInput([
			"readonly" => "true"
		]);
	}
}

print "<hr>";

print \yii\helpers\Html::tag("div", \yii\helpers\Html::tag("button", "Создать", [
	"class" => "btn btn-primary builder-compile-button",
	"type" => "button"
]), [ "class" => "col-xs-12 clear text-right" ]);

$form->end();