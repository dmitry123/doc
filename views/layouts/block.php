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
	<div class="page-block">
		<div class="row">
			<div class="page-content col-xs-12">
				<?= $content ?>
			</div>
		</div>
	</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>