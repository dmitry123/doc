<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */
app\assets\MainAsset::register($this);
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
				id: <?= "\"".Yii::$app->getUser()->getIdentity()->{"id"}."\"" ?>,
				login: <?= "\"".Yii::$app->getUser()->getIdentity()->{"login"}."\"\n" ?>
			},
			employee: {
				id: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_ID", "")."\"" ?>,
				surname: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_SURNAME", "")."\"" ?>,
				name: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_NAME", "")."\"" ?>,
				patronymic: <?= "\"".Yii::$app->getSession()->get("EMPLOYEE_PATRONYMIC", "")."\"\n" ?>
			},
			url: <?= "\"".Yii::$app->getRequest()->getBaseUrl()."\"\n" ?>
		};
	</script>
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-content">
	<?= \app\widgets\Navigation::widget(); ?>
	<div class="col-xs-12">
		<div class="col-xs-10" id="page-content">
			<?= $content ?>
		</div>
		<div class="col-xs-2">
			
		</div>
	</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>