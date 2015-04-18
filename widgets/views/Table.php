<?php
/**
 * @var \yii\web\View $this
 * @var app\widgets\Table $self
 */
?>
<table class="<?= $self->tableClass ?> core-table" id="<?= $self->id ?>" <?php $self->renderExtra() ?> data-widget="<?= get_class($self) ?>" data-attributes="<?= $self->getSerializedAttributes() ?>">
	<thead class="core-table-header">
	<?php $self->renderHeader() ?>
	</thead>
	<tbody class="core-table-body">
	<?php $self->renderBody() ?>
	</tbody>
	<tfoot class="core-table-footer">
	<?php $self->renderFooter() ?>
	</tfoot>
</table>