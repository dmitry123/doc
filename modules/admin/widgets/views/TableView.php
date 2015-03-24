<?php
use app\modules\admin\widgets\TableView;
use yii\web\View;
/**
 * @var $this View
 * @var $self TableView
 */
?>

<div class="panel panel-default table-panel-wrapper">
<div class="panel-heading"><?= $self->title ?></div>
<div class="panel-body">
<ul class="nav nav-pills nav-stacked table-list">
<?php foreach ($self->list as $key => $table): ?>
	<li role="presentation" data-table="<?= $table["table"] ?>">
		<a href="javascript:void(0)">
			<span class="glyphicon glyphicon-unchecked"></span>
			<span>&nbsp;&nbsp;<?= $table["name"] ?></span>
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
</div>
</div>