<?php
/**
 * @var View $this
 * @var bool $admin
 */
use yii\web\View;
?>

<nav id="navigation" class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
	<div class="navbar-header">
		<a class="navbar-brand" href="#">Документооборот</a>
	</div>
	<ul class="nav navbar-nav navbar-right">
		<? if ($admin): ?>
		<li><a href="#">Администратор&nbsp;<span class="caret"><span class="sr-only"></span></a></li>
		<? endif; ?>
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
<!--<div class="user-panel-wrapper">-->
<!--	--><?//= \app\widgets\UserPanel::widget(); ?>
<!--</div>-->