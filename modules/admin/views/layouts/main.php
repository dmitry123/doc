<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */

\app\assets\AdminAsset::register($this);

print $this->renderPhpFile(Yii::$app->getLayoutPath() . "/main.php", [
	"content" => $content
]);