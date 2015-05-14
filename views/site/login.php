<?php
/**
 * @var $this View
 */
use yii\web\View;
?>

<?php \app\widgets\Logo::begin() ?>
<?php $form = \yii\widgets\ActiveForm::begin([
	"fieldClass" => "\\app\\core\\ActiveField",
	"id" => "user-login-form",
	"action" => Yii::$app->getUrlManager()->createUrl("user/login")
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
	<button class="btn btn-danger btn-lg" id="register-button" type="button">Регистрация</button>
</div>
<?php \yii\widgets\ActiveForm::end() ?>
<?php \app\widgets\Logo::end() ?>