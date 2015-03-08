<?php
/**
 * @var View $this - View instance
 */

use yii\web\View;
?>

<nav id="navigation" class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">Документооборот</a>
		</div>
		<div class="navigation-login-wrapper">
			<?= \app\widgets\NavigationLogin::widget() ?>
		</div>
<!--		<ul class="nav navbar-nav navbar-left">-->
<!--			<li><a href="#">Link</a></li>-->
<!--			<li class="dropdown">-->
<!--				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>-->
<!--				<ul class="dropdown-menu" role="menu">-->
<!--					<li><a href="#">Action</a></li>-->
<!--					<li><a href="#">Another action</a></li>-->
<!--					<li><a href="#">Something else here</a></li>-->
<!--					<li class="divider"></li>-->
<!--					<li><a href="#">Separated link</a></li>-->
<!--				</ul>-->
<!--			</li>-->
<!--		</ul>-->
	</div>
</nav>