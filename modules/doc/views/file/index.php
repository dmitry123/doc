<?php
/**
 * @var $this yii\web\View
 */

print \app\modules\doc\widgets\FilePage::widget([
	"tableActiveRecord" => new \app\models\Document(),
	"textList" => "Список документов",
	"textHistory" => "История изменения документа",
	"textInfo" => "Информация о документе",
]);