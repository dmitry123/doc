<?php
/**
 * @var $this \yii\web\View
 * @var $items array
 */
?>
<nav class="navbar navbar-default navbar-fixed-top editor-control-menu-nav">
	<div class="container-fluid clear">
		<div class="navbar-header module-menu-title">
		</div>
		<ul class="nav navbar-nav navbar-left">
			<?php foreach ($items as $class => $item): ?>
				<li>
					<a href="javascript:void(0)" class="<?= $class ?>">
						<span class="<?= $item["icon"] ?>"></span> <?= $item["label"] ?>
					</a>
				</li>
			<?php endforeach ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		</ul>
	</div>
</nav>