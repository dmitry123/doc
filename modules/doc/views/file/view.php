<?php
/**
 * @var $this yii\web\View
 */
?>
<div class="col-xs-12">
	<div class="col-xs-8 clear">
	<?= \app\widgets\Panel::widget([
		"title" => "Список файлов",
		"body" => \app\widgets\Grid::create([
			"provider" => new \app\tables\FileTable()
		]),
		"bodyClass" => "panel-body clear"
	]) ?>
	</div>
	<div class="col-xs-4">
		<?= \app\widgets\Panel::widget([
			"title" => "Тип файла"
		]) ?>
		<hr>
		<?= \app\widgets\Panel::widget([
			"title" => "Информация"
		]) ?>
		<hr>
		<?= \app\widgets\Panel::widget([
			"title" => "История"
		]) ?>
	</div>
</div>