<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */
app\assets\DocAsset::register($this);

print $this->renderFile(Yii::$app->getLayoutPath() . "/main.php", [
	"content" => $content
]);