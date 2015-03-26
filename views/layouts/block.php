<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 * @var $test string
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
	<div class="page-block row">
		<div class="page-content col-xs-12">
			<?= $content ?>
		</div>
	</div>
</div>
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