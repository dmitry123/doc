<?php
/**
 * @var $this yii\web\View - Render instance
 */

echo \app\widgets\Modal::widget([
	"id" => "login-modal",
	"title" => "Вход",
	"body" => \app\widgets\Form::widget([
		"model" => new \app\forms\LoginForm("login")
	]),
	"buttons" => [
		"register-button" => [
			"class" => "btn btn-primary",
			"text" => "Сохранить",
			"type" => "submit"
		]
	]
]); ?>

<button class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Click On Me</button>
<br><br><br><br><br><br>
<div style="width: 400px">
	<select id="test-multiple" class="form-control" multiple title="">
		<? for ($i = 0; $i < 5; $i++): ?>
			<option value="<?= $i ?>"><?= bin2hex(openssl_random_pseudo_bytes(10)) ?></option>
		<? endfor; ?>
	</select>
</div>