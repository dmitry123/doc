<?
/**
 * @var $this View
 */
use yii\web\View;

print \app\widgets\Modal::widget([
	"title" => "Регистрация",
	"body" => \app\widgets\Form::widget([
		"model" => new \app\forms\UserForm("register"),
		"id" => "user-register-form",
		"url" => \yii\helpers\Url::toRoute("user/register")
	]),
	"id" => "user-register-modal",
	"buttons" => [
		"register" => [
			"text" => "Регистрация",
			"class" => "btn btn-primary",
			"type" => "submit"
		]
	]
]);

$form = \yii\widgets\ActiveForm::begin([
	"fieldClass" => "\\app\\core\\ActiveField",
	"action" => \yii\helpers\Url::toRoute("user/login")
]); ?>

<div class="input-group input-group-lg block-field">
	<span class="input-group-addon glyphicon glyphicon-user" id="addon-login"></span>
	<input type="text" name="LoginForm[login]" class="form-control" placeholder="Логин" aria-describedby="addon-login">
</div>
<div class="input-group input-group-lg block-field">
	<span class="input-group-addon glyphicon glyphicon-lock" id="addon-password"></span>
	<input type="password" name="LoginForm[password]" class="form-control" placeholder="Пароль" aria-describedby="addon-password">
</div>
<div class="btn-group login-button-group" role="group">
	<button class="btn btn-primary btn-lg" type="submit">Войти</button>
	<button class="btn btn-danger btn-lg" type="button" data-toggle="modal" data-target="#user-register-modal">Регистрация</button>
</div>

<? \yii\widgets\ActiveForm::end() ?>