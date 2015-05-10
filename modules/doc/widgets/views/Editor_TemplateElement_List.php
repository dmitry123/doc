<?php
/**
 * @var $this \yii\web\View
 * @var $items array
 */
?>
<div class="col-xs-12 template-element-collection">
	<?php foreach ($items as $key => $item): ?>
		<div class="col-xs-4 text-center template-element-wrapper">
			<?= $item ?>
		</div>
	<?php endforeach ?>
</div>
