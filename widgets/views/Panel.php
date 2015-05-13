<?php
/**
 * @var $self app\widgets\Panel
 * @var $content string
 * @var $widget string
 * @var $parameters string
 */
?>

<div class="<?= $self->panelClass ?>" id="<?= $self->id ?>" <?= !empty($widget) ? "data-widget=\"$widget\"" : "" ?> <?= !empty($parameters) && $self->upgradeable ? "data-attributes=\"$parameters\"" : "" ?>>
    <div class="<?= $self->headingClass ?>">
		<div class="<?= $self->titleWrapperClass ?>">
			<span class="<?= $self->titleClass ?>"><?= $self->title ?></span>
		</div>
		<div class="<?= $self->controlsWrapperClass ?>">
			<?php $self->renderControls() ?>
		</div>
    </div>
    <div class="<?= $self->bodyClass ?>">
		<div class="row no-padding no-margin">
			<div class="<?= $self->contentClass ?>">
				<?= $content ?>
			</div>
		</div>
	</div>
</div>