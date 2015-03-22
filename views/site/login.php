<?
/**
 * @var $this View
 */
use yii\web\View;

$form = \yii\widgets\ActiveForm::begin([
	"fieldClass" => "\\app\\core\\ActiveField",
	"id" => "user-login-form",
	"action" => \yii\helpers\Url::to("@web/user/login")
]); ?>

<div class="input-group input-group-lg block-field">
	<span class="input-group-addon glyphicon glyphicon-user" id="addon-login"></span>
	<input id="login" value="system" type="text" name="UserForm[login]" class="form-control" placeholder="Логин или Email" aria-describedby="addon-login">
</div>
<div class="input-group input-group-lg block-field">
	<span class="input-group-addon glyphicon glyphicon-lock" id="addon-password"></span>
	<input id="password" value="super123" type="password" name="UserForm[password]" class="form-control" placeholder="Пароль" aria-describedby="addon-password">
</div>
<div class="btn-group login-button-group" role="group">
	<button class="btn btn-primary btn-lg" id="login-button" type="button">Войти</button>
	<button class="btn btn-danger btn-lg" type="button" data-toggle="modal" data-target="#user-register-modal">Регистрация</button>
</div>

<? \yii\widgets\ActiveForm::end() ?>