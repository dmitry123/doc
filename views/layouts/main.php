<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 */
app\assets\AppAsset::register($this);
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
<div class="wrap">
	<?= \app\widgets\Navigation::widget(); ?>
	<div class="col-xs-12 container">
		<? if (!Yii::$app->getUser()->getIsGuest()): ?>
			<div class="col-xs-3">
				<?= \app\widgets\SideMenu::widget() ?>
			</div>
			<div class="col-xs-9">
				<?= $content ?>
			</div>
		<? endif ?>
	</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>