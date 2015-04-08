<?php
/**
 * @var $this yii\web\View
 * @var $content string
 * @var $self app\widgets\Panel
 */
?>
<div class="<?= $self->panelClass ?>">
	<div class="<?= $self->headingClass ?>">
		<div class="col-xs-10 text-left no-padding">
			<?= $self->title ?>
		</div>
		<div class="col-xs-2 text-right no-padding">
			<?php if ($self->update != false): ?>
				<span class="glyphicon glyphicon-refresh doc-file-type-refresh-icon" onclick="$('this').panel('update')"></span>
			<?php endif ?>
		</div>
	</div>
	<div class="<?= $self->bodyClass ?>">
		<?= $content ?>
	</div>
</div>