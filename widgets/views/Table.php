<?php
/**
 * @var \yii\web\View $this
 * @var Table $self
 */
?>
<table class="<?= $self->tableClass ?> core-table" id="<?= $self->id ?>" <?php $self->renderExtra() ?>>
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