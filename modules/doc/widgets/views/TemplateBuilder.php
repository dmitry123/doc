<?php
/**
 * @var $this \yii\web\View
 * @var $file mixed
 */
print \app\widgets\Modal::widget([
	'title' => 'Создание нового элемента',
	'body' => \app\modules\doc\widgets\MacroMaker::widget([
		'static' => 'false'
	]),
	'buttons' => [
		'builder-save-macro-button' => [
			'text' => 'Сохранить',
			'class' => 'btn btn-primary',
			'type' => 'button',
			'onclick' => '',
		]
	],
	'id' => 'builder-create-element-modal'
]);
print \app\widgets\Modal::widget([
	'title' => 'Поиск элементов',
	'body' => \app\widgets\Grid::widget([
		'provider' => new \app\modules\doc\grids\MacroGridProvider([
			'static' => 0, 'file' => $file->{'id'}
		])
	]),
	'buttons' => [
		'builder-apply-macro-button' => [
			'text' => 'Выбрать',
			'class' => 'btn btn-primary',
			'type' => 'button'
		]
	],
	'id' => 'builder-find-element-modal',
]);
print \app\widgets\Modal::widget([
	'title' => 'Просмотр списка элементов',
	'body' => \app\widgets\Grid::widget([
		'provider' => new \app\modules\doc\grids\MacroGridProvider([
			'static' => 0, 'file' => $file->{'id'}
		])
	]),
	'id' => 'builder-view-element-modal'
]);
print \app\widgets\Modal::widget([
	'title' => 'Создание нового макроса',
	'body' => \app\modules\doc\widgets\MacroMaker::widget([
		'static' => 'true'
	]),
	'buttons' => [
		'builder-save-macro-button' => [
			'text' => 'Сохранить',
			'class' => 'btn btn-primary',
			'type' => 'button',
			'onclick' => '',
		]
	],
	'id' => 'builder-create-macro-modal'
]);
print \app\widgets\Modal::widget([
	'title' => 'Поиск макроса',
	'body' => \app\widgets\Grid::widget([
		'provider' => new \app\modules\doc\grids\MacroGridProvider([
			'static' => 1
		])
	]),
	'buttons' => [
		'builder-apply-macro-button' => [
			'text' => 'Выбрать',
			'class' => 'btn btn-primary',
			'type' => 'button'
		]
	],
	'id' => 'builder-find-macro-modal',
]);
print \app\widgets\Modal::widget([
	'title' => 'Просмотр списка макросов',
	'body' => \app\widgets\Grid::widget([
		'provider' => new \app\modules\doc\grids\MacroGridProvider([
			'static' => 1
		])
	]),
	'id' => 'builder-view-macro-modal'
]) ?>
<?= \app\modules\doc\widgets\EditorFileMenu::widget() ?>
<div class='col-xs-12 editor-template-builder-wrapper'>
	<div class='col-xs-8'>
		<?= \app\widgets\Panel::widget([
			'title' => 'Содержимое файла',
			'id' => 'doc-editor-content-panel',
			'body' => \app\modules\doc\widgets\TemplateEditor::create([
				'file' => $file->{'id'}
			]),
			'bodyClass' => 'panel-body clear',
			'upgradable' => false
		]) ?>
	</div>
	<div class='col-xs-4 builder-panel-wrapper'>
		<?= \app\widgets\Panel::widget([
			'title' => 'Макросы',
			'bodyClass' => 'panel-body clear',
			'titleWrapperClass' => 'col-xs-2 text-left no-padding',
			'controlsWrapperClass' => 'col-xs-10 text-right no-padding',
			'id' => 'builder-macro-panel',
			'body' => \app\widgets\Grid::create([
				'provider' => new \app\modules\doc\grids\MacroGridProvider([
					'static' => 1, 'file' => $file->{'id'}
				])
			]),
			'controls' => [
				'builder-insert-macro' => [
					'label' => 'Добавить',
					'icon' => 'fa fa-plus',
					'class' => 'btn btn-primary btn-xs',
					'data-toggle' => 'modal',
					'data-target' => '#builder-create-macro-modal',
				],
				'panel-update-button' => [
					'label' => 'Обновить',
					'icon' => 'glyphicon glyphicon-refresh',
					'onclick' => '$(this).panel("update")',
					'class' => 'btn btn-default btn-xs',
				],
			],
			'upgradable' => false
		]) ?>
		<hr>
		<?= \app\widgets\Panel::widget([
			'title' => 'Элементы',
			'bodyClass' => 'panel-body clear',
			'titleWrapperClass' => 'col-xs-2 text-left no-padding',
			'controlsWrapperClass' => 'col-xs-10 text-right no-padding',
			'id' => 'builder-element-panel',
			'body' => \app\widgets\Grid::create([
				'provider' => new \app\modules\doc\grids\MacroGridProvider([
					'static' => 0, 'file' => $file->{'id'}
				])
			]),
			'controls' => [
				'builder-insert-macro' => [
					'label' => 'Добавить',
					'icon' => 'fa fa-plus',
					'class' => 'btn btn-primary btn-xs',
					'data-toggle' => 'modal',
					'data-target' => '#builder-create-element-modal',
				],
				'panel-update-button' => [
					'label' => 'Обновить',
					'icon' => 'glyphicon glyphicon-refresh',
					'onclick' => '$(this).panel("update")',
					'class' => 'btn btn-default btn-xs',
				],
			],
			'upgradable' => false
		]) ?>
		<hr>
		<div class='col-xs-12 clear text-center'>
			<button class='btn btn-primary builder-save-button'><i class='fa fa-save'></i>&nbsp;Сохранить</button>
			<button class='btn btn-default' onclick='$("body").animate({ scrollTop: 0 }, "500", "swing")'><i class='fa fa-arrow-up'></i></button>
			<button class='btn btn-default' onclick='$("body").animate({ scrollTop: $("body").height() }, "500", "swing")'><i class='fa fa-arrow-down'></i></button>
		</div>
	</div>
</div>