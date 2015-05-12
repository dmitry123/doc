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
					<?php if (isset($item["items"]) && count($item["items"]) > 0): ?>
						<a href="javascript:void(0)" class="dropdown-toggle <?= $class ?>" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="<?= $item["icon"] ?>"></span>&nbsp;<?= $item["label"] ?>&nbsp;<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<?php foreach ($item["items"] as $c => $it): ?>
								<li>
									<a href="javascript:void(0)" class="<?= $c ?>">
										<span class="<?= $it["icon"] ?>"></span>&nbsp;<?= $it["label"] ?>
									</a>
								</li>
							<?php endforeach ?>
						</ul>
					<?php else: ?>
						<a href="javascript:void(0)" class="<?= $class ?>">
							<span class="<?= $item["icon"] ?>"></span>&nbsp;<?= $item["label"] ?>
						</a>
					<?php endif ?>
				</li>
			<?php endforeach ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		</ul>
	</div>
</nav>