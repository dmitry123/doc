<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<?php \app\widgets\Logo::begin([
	"controls" => [
		"error-main-button" => [
			"label" => "Главная",
			"icon" => "glyphicon glyphicon-home",
			"class" => "btn btn-primary btn-block",
			"type" => "button"
		]
	]
]) ?>
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode(Yii::t("app", $message))) ?>
    </div>
    <p>The above error occurred while the Web server was processing your request.</p>
    <p>Please contact us if you think this is a server error. Thank you.</p>
</div>
<?php \app\widgets\Logo::end() ?>