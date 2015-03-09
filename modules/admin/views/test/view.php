<div class="col-xs-12">
	<div class="col-xs-4">
		<h3>Login</h3>
	</div>
	<div class="col-xs-4">
		<h3>Register</h3>
	</div>
	<div class="col-xs-4">
		<h3>Update</h3>
	</div>
</div>
<div class="col-xs-12">
	<div class="col-xs-4">
		<?= \app\widgets\Form::widget([ "model" => new \app\forms\UserForm("login") ]) ?>
	</div>
	<div class="col-xs-4">
		<?= \app\widgets\Form::widget([ "model" => new \app\forms\UserForm("register") ]) ?>
	</div>
	<div class="col-xs-4">
		<?= \app\widgets\Form::widget([ "model" => new \app\forms\UserForm("update") ]) ?>
	</div>
</div>