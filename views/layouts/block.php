<?php
/**
 * @var $this \yii\web\View
 * @var $content string
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
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-content" class="page-block">
	<table align="center">
		<tr>
			<td valign="middle" width="150px">
				<?= \yii\helpers\Html::img("img/logo-big.png", [
					"width" => "100%"
				]) ?>
			</td>
			<td valign="middle" style="width: 50px"></td>
			<td valign="middle">
				<?= $content ?>
			</td>
		</tr>
	</table>
<!--	<div class="col-xs-12">-->
<!--		<div class="col-xs-4">-->
<!--			--><?//= \yii\helpers\Html::img("img/logo-big.png", [
//				"width" => "100%"
//			]) ?>
<!--		</div>-->
<!--		<div class="col-xs-8">-->
<!--			--><?//= $content ?>
<!--		</div>-->
<!--	</div>-->
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>