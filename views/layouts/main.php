<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */
app\assets\CoreAsset::register($this);
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
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-content">
	<?= \app\widgets\Navigation::widget(); ?>
	<div class="col-xs-12">
<!--		<div class="col-xs-3">-->
<!--			--><?//= \app\widgets\SideMenu::widget() ?>
<!--		</div>-->
<!--		<div class="col-xs-9" id="page-content">-->
			<?= $content ?>
<!--		</div>-->
	</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>