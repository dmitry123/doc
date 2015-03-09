<?php
/**
 * @var $this yii\web\View - Render instance
 */

echo \app\widgets\Modal::widget([
	"id" => "register-modal",
	"title" => "Регистрация",
	"body" => \app\widgets\Form::widget([
		"model" => new \app\forms\UserForm("register")
	]),
	"buttons" => [
		"register-button" => [
			"class" => "btn btn-primary",
			"text" => "Сохранить",
			"type" => "submit"
		]
	]
]);
?>

<div class="col-xs-6">
	<?= \app\widgets\Form::widget([
		"model" => new \app\forms\UserForm("login")
	]); ?>
</div>