<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\admin\widgets\TableMenu
 */
?>

<ul class="nav nav-pills nav-stacked table-list">
<?php foreach ($self->list as $key => $table): ?>
	<li role="presentation" data-table="<?= $table["table"] ?>" data-model="<?= $table["model"] ?>">
		<a href="javascript:void(0)">
			<span class="glyphicon glyphicon-unchecked"></span>
			<span>&nbsp;&nbsp;<?= $table["label"] ?></span>
		</a>
		<ul class="nav nav-pills nav-stacked table-column-list">
		<?php foreach ($table["info"] as $info): ?>
			<li role="presentation" data-column="<?= $info["name"] ?>">
				<a href="javascript:void(0)">
					<span class="glyphicon glyphicon-minus"></span>
					<span>&nbsp;<?= isset($info["label"]) ? $info["label"] : $info["name"] ?></span>
				</a>
			</li>
		<?php endforeach ?>
		</ul>
	</li>
<?php endforeach ?>
</ul>