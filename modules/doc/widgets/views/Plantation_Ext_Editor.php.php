<?php
/**
 * @var $self app\modules\doc\widgets\Plantation
 */
$ft = \app\components\UniqueGenerator::generate("tab");
$fe = \app\components\UniqueGenerator::generate("tab");
print \app\components\widgets\Modal::widget([
	"title" => "Добавить \"Тип файла\"",
	"id" => "doc-plantation-file-type-register-modal",
	"body" => "Hello, World"
]) ?>
<?= \app\components\widgets\ControlMenu::widget([
	"controls" => [
		"plantation-file-type-button" => [
			"label" => "Типы файлов",
			"class" => "btn-success",
			"onclick" => "$(this).parents('.btn-group').find('.btn').removeClass('btn-success'); $(this).tab('show').addClass('btn-success')",
			"data-target" => "#".$ft
		],
		"plantation-file-extension-button" => [
			"label" => "Расширения файлов",
			"onclick" => "$(this).parents('.btn-group').find('.btn').removeClass('btn-success'); $(this).tab('show').addClass('btn-success')",
			"data-target" => "#".$fe
		]
	],
	"mode" => \app\components\widgets\ControlMenu::MODE_LIST
]) ?>

<div class="tab-content">
	<div class="tab-pane active in" id="<?= $ft ?>">
	<?= \app\components\widgets\Panel::widget([
		"title" => "Типы файлов",
		"body" => \app\modules\doc\widgets\FileTypeTable::create(),
		"controls" => [
			"panel-insert-button" => [
				"label" => "Добавить",
				"icon" => "glyphicon glyphicon-plus",
				"class" => "btn btn-primary btn-sm",
				"data-toggle" => "modal",
				"data-target" => "#doc-plantation-file-type-register-modal"
			],
			"panel-update-button" => [
				"label" => "Обновить",
				"icon" => "glyphicon glyphicon-refresh",
				"onclick" => "$(this).panel('update')",
				"class" => "btn btn-default btn-sm",
			],
		],
		"bodyClass" => "panel-body no-padding"
	]) ?>
	</div>
	<div class="tab-pane fade" id="<?= $fe ?>">
	<?= \app\components\widgets\Panel::widget([
		"title" => "Расширения файлов",
		"body" => \app\modules\doc\widgets\FileExtTable::create(),
		"controls" => [
			"panel-insert-button" => [
				"label" => "Добавить",
				"icon" => "glyphicon glyphicon-plus",
				"class" => "btn btn-primary btn-sm",
				"data-toggle" => "modal",
				"data-target" => "#doc-plantation-file-type-register-modal"
			],
			"panel-update-button" => [
				"label" => "Обновить",
				"icon" => "glyphicon glyphicon-refresh",
				"onclick" => "$(this).panel('update')",
				"class" => "btn btn-default btn-sm",
			],
		],
		"bodyClass" => "panel-body no-padding"
	]) ?>
	</div>
</div>