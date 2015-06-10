<?php
/**
 * @var $this yii\web\View
 * @var $ext app\modules\doc\extensions\Service
 * @var $type
 */
print \app\widgets\Panel::widget([
	'title' => 'Список файлов',
	'body' => \app\widgets\Grid::widget([
		'provider' => new \app\modules\doc\grids\DocumentGridProvider([
			'tableClass' => 'table table-striped doc-file-document-grid',
			'menu' => [
				'controls' => [
					'service-document-remove-icon' => [
						'label' => 'Удалить',
						'icon' => 'fa fa-trash fa-danger',
						'onclick' => 'confirmDelete()',
					]
				],
				'mode' => \app\widgets\ControlMenu::MODE_ICON
			],
			'type' => $type
		])
	]),
	'bodyClass' => 'panel-body clear',
]);