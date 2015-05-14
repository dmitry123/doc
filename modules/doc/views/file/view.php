<?php
/**
 * @var $this yii\web\View
 */
?>
<div class="col-xs-12">
	<div class="col-xs-8 clear">
	<?= \app\components\widgets\Panel::widget([
		"title" => "Список файлов",
		"body" => \app\components\widgets\Grid::create([
			"provider" => new \app\components\tables\FileTable()
		]),
		"bodyClass" => "panel-body clear"
	]) ?>
	</div>
	<div class="col-xs-4">
		<?= \app\components\widgets\Panel::widget([
			"title" => "Тип файла"
		]) ?>
		<hr>
		<?= \app\components\widgets\Panel::widget([
			"title" => "Информация"
		]) ?>
		<hr>
		<?= \app\components\widgets\Panel::widget([
			"title" => "История"
		]) ?>
	</div>
</div>