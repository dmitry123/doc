<?php
/**
 * @var View $this - View instance
 */
use yii\web\View;
?>

<nav id="navigation" class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
	<div class="navbar-header">
		<a class="navbar-brand" href="#">Документооборот</a>
	</div>
	<form class="navbar-form navbar-left">
	</form>
	<ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
				<span class="glyphicon glyphicon-user"></span>
				&nbsp;<?= Yii::$app->getUser()->getId() ?>&nbsp;
				<span class="glyphicon glyphicon-arrow-left"></span>
			</a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#">Пусто</a></li>
				<li><a href="#">Пусто</a></li>
				<li><a href="#">Пусто</a></li>
				<li class="divider"></li>
				<li><a class="btn btn-danger" href="<?= \yii\helpers\Url::toRoute("user/logout") ?>">Выйти</a></li>
			</ul>
		</li>
	</ul>
</div>
</nav>
<div class="user-panel-wrapper col-xs-12 navbar-default">
	<?= \app\widgets\UserPanel::widget(); ?>
</div>