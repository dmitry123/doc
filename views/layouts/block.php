<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 * @var $logo bool
 */
app\assets\BlockAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= yii\helpers\Html::csrfMetaTags() ?>
	<title><?= yii\helpers\Html::encode($this->title) ?></title>
	<?php $this->head() ?>
	<script type="text/javascript">
		var doc = {
			url: <?= "\"".Yii::$app->getRequest()->getBaseUrl()."\"\n" ?>
		};
	</script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-content">
	<div class="page-block">
		<table align="center" class="page-content">
			<tr>
				<td valign="middle" width="150px">
					<?= \yii\helpers\Html::img("img/logo-big.png", [
						"width" => "100%"
					]) ?>
					<? if (!Yii::$app->getUser()->getIsGuest()): ?>
						<div class="col-xs-12 block-user-info">
							<hr>
							<div>
								<b><?= \app\core\EmployeeManager::getIdentity(1) ?></b><br>
								<?= \app\core\EmployeeManager::getInfo()["role_name"] ?>
							</div>
							<hr>
							<button class="btn btn-danger btn-block block-logout">Выйти</button>
						</div>
					<? endif ?>
				</td>
				<td valign="middle" style="width: 50px">
				</td>
				<td valign="middle">
					<?= $content ?>
				</td>
			</tr>
		</table>
	</div>
</div>
<!-- TODO - "Remove that modal from layout, can't put it in view, cuz it will crash animation" -->
<?= \app\widgets\Modal::widget([
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
]); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>