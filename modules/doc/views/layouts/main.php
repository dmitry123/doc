<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */
app\assets\DocAsset::register($this);

ob_start();

print \app\widgets\Modal::widget([
	"title" => "Загрузка документов",
	"body" => \yii\helpers\Html::input("file", "files[]", null, [
		"id" => "document-file-upload",
		"multiple" => "true",
		"class" => "file-loading",
		"name" => "files[]"
	]),
	"id" => "file-upload-modal",
	"size" => "modal-lg",
	"wrapper" => "col-xs-12"
]);

print \app\widgets\Modal::widget([
    "title" => "Мастер файл",
    "body" => \app\modules\doc\widgets\MasterTable::widget([

    ]),
    "id" => "file-master-modal",
    "wrapper" => "col-xs-12"
]);

print $this->renderFile(Yii::$app->getLayoutPath() . "/main.php", [
	"content" => $content . ob_get_clean()
]);