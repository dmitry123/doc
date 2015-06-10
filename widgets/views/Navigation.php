<?php
/**
 * @var View $this
 * @var bool $admin
 * @var array $menu
 * @var Navigation $self
 */
use app\core\Module;
use app\widgets\Navigation;
use yii\web\View;
?>

<nav id="navigation" class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
	<div class="navbar-header module-menu-title">
		<a class="navbar-brand" href="javascript:void(0)">
			МГУП<?= \app\core\ModuleHelper::currentModuleName() ?>&nbsp;<span class="caret"></span>
			<?= \app\widgets\ModuleMenu::widget() ?>
		</a>
	</div>
	<ul class="nav navbar-nav navbar-left">
	</ul>
	<ul class="nav navbar-nav navbar-right">
		<?php $self->renderItem($menu) ?>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
				<span class="glyphicon glyphicon-user"></span>
				&nbsp;<?= \app\core\EmployeeHelper::getHelper()->getIdentity(1) ?>&nbsp;<span class="caret">
			</a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#">Пусто</a></li>
				<li><a href="#">Пусто</a></li>
				<li><a href="#">Пусто</a></li>
			</ul>
		</li>
		<li><a href="<?= \yii\helpers\Url::to("@web/user/logout") ?>"><span class="fa fa-sign-out"></span></a></li>
	</ul>
</div>
</nav>