<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */
app\assets\SiteAsset::register($this);
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
			user: {
				login: <?= "\"".Yii::$app->getSession()->get("USER_LOGIN")."\"" ?>,
				id: <?= "\"".Yii::$app->getSession()->get("USER_ID")."\"" ?>,
				email: <?= "\"".Yii::$app->getSession()->get("USER_EMAIL")."\"\n" ?>
			},
			employee: {
				id: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_ID", "")."\"" ?>,
				surname: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_SURNAME", "")."\"" ?>,
				name: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_NAME", "")."\"" ?>,
				patronymic: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_PATRONYMIC", "")."\"\n" ?>
			},
			url: <?= "\"".Yii::$app->getRequest()->getBaseUrl()."\"" ?>,
			widget: <?= "\"".\app\core\Widget::createUrl()."\"\n" ?>
		};
	</script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-content">
	<?= \app\widgets\Navigation::widget(); ?>
	<div class="row no-margin no-padding">
		<div class="col-xs-12" id="page-content">
			<?= $content ?>
		</div>
	</div>
</div>
<?= \app\widgets\ConfirmModal::widget(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>