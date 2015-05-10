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
		"title" => "Информация",
		"body" => \app\modules\doc\widgets\Editor_AboutTemplate_Editor::create([
			"file" => null
		])
	]) ?>
	<hr>
	<?= \app\widgets\Panel::widget([
		"title" => "Элементы шаблонов",
		"body" => \app\modules\doc\widgets\Editor_TemplateElement_List::create([
			"manager" => \app\modules\doc\core\ElementManager::getManager()
		]),
		"controls" => [
			"panel-create-button" => [
				"label" => "Создать",
				"icon" => "glyphicon glyphicon-plus",
				"class" => "btn btn-primary btn-sm"
			],
			"panel-update-button" => [
				"label" => "Обновить",
				"icon" => "glyphicon glyphicon-refresh",
				"onclick" => "$(this).panel('update')",
				"class" => "btn btn-default btn-sm",
			],
		]
	]) ?>
	<hr>
	<div class="btn-group">
		<button class="btn btn-success btn-lg">
			<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Сохранить
		</button>
	</div>
	</div>
</div>