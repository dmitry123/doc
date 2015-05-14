<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */
app\assets\SiteAsset::register($this);
$parameters = [
	"user" => [
		"login" => Yii::$app->getSession()->get("USER_LOGIN"),
		"id" => Yii::$app->getSession()->get("USER_ID"),
		"email" => Yii::$app->getSession()->get("USER_EMAIL")
	],
	"employee" => [
		"surname" => Yii::$app->getSession()->get("EMPLOYEE_SURNAME", ""),
		"name" => Yii::$app->getSession()->get("EMPLOYEE_NAME", ""),
		"patronymic" => Yii::$app->getSession()->get("EMPLOYEE_PATRONYMIC", ""),
		"id" => Yii::$app->getSession()->get("EMPLOYEE_ID", "")
	],
	"url" => Yii::$app->getUrlManager()->createUrl(""),
	"widget" => "ext/widget",
	"module" => Yii::$app->controller->module->id,
	"ext" => "ext/load",
]; ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= yii\helpers\Html::csrfMetaTags() ?>
<title><?= yii\helpers\Html::encode($this->title) ?></title>
<?php $this->head() ?>
<?= "\n" ?>
<script type="text/javascript">
var doc = <?= json_encode($parameters, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-content">
	<?= \app\widgets\Navigation::widget(); ?>
	<div class="row">
		<div class="col-xs-12 no-padding" id="page-content">
			<?= $content ?>
		</div>
	</div>
</div>
<?= \app\widgets\ConfirmModal::widget(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>