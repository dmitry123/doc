<?php
/**
 * @var $this yii\web\View
 * @var $content string
 * @var $self app\widgets\Panel
 */
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<span><?= $self->title ?></span>
	</div>
	<div class="panel-body <?= $self->align ?>">
		<?= $content ?>
	</div>
</div>