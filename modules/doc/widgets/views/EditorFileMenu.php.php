<?php
/**
 * @var $this \yii\web\View
 * @var $items array
 * @var $self app\modules\doc\widgets\EditorFileMenu
 */
?>
<nav class="navbar navbar-default navbar-fixed-top editor-control-menu-nav">
	<div class="container-fluid clear">
		<div class="navbar-header module-menu-title">
		</div>
		<ul class="nav navbar-nav navbar-left">
            <?php $self->renderItems($items) ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		</ul>
	</div>
</nav>