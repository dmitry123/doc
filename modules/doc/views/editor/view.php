<?php
/**
 * @var $this \yii\web\View
 * @var $file int
 */
?>

<div class="col-xs-12">
	<div class="col-xs-7 clear">
	<?= \app\widgets\Panel::widget([
		"title" => "Содержимое файла",
		"body" => \app\modules\doc\widgets\Editor_TemplateContent_Editor::create([
			"file" => $file
		])
	]) ?>
	</div>
	<div class="col-xs-5">
	<?= \app\widgets\Panel::widget([
		"title" => "Элементы шаблонов",
		"body" => "Hello"
	]) ?>
	</div>
</div>