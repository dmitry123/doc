<?php
/**
 * @var $this yii\web\View
 */

print \app\modules\doc\widgets\FilePage::widget([
	"tableActiveRecord" => new \app\models\FileTemplate(),
	"textList" => "Список шаблонов",
	"textHistory" => "История изменения шаблона",
	"textInfo" => "Информация о шаблоне",
]);