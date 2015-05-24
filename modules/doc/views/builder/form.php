<?php
use app\models\doc\File;
use app\models\doc\Macro;
/**
 * @var $file File
 * @var $content string
 * @var $macro array
 */

require "vendor/cdom/CDom.php";

$html = CDom::fromString($content);

print \yii\helpers\Html::beginTag("div", [
	"class" => "col-xs-5"
]);

\app\widgets\Panel::begin([
	"title" => "Форма шаблона"
]);

$form = \app\widgets\ActiveForm::begin([
	"action" => Yii::$app->getUrlManager()->createUrl([ "doc/builder/save" ])
]);

print "<pre>";
print_r($macro);
print "</pre>";

$model = new \yii\base\DynamicModel([]);

foreach ($macro as $m) {
	$a = $html->find($m["path"]);
	if (!count($a)) {
		continue;
	}
	$element = $a[0];
	$str = $element->html();
	$str = str_replace($m["content"], $m["value"], $str);
	$element->html($str);
}

$form->end();
\app\widgets\Panel::end();

print \yii\helpers\Html::endTag("div");