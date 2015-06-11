<?php

namespace app\modules\doc\extensions;

use app\core\Ext;

class Service extends Ext {

	public $action;

	public $js = [
		'js/doc.js'
	];

	public $css = [
		'css/doc.css'
	];

	function actionMenu() {
		return [
			'file' => [
				'label' => 'Файлы',
				'icon' => 'fa fa-file-text-o',
				'items' => [
					'document' => [
						'label' => 'Документы',
						'icon' => 'fa fa-angle-right',
					],
					'template' => [
						'label' => 'Шаблоны',
						'icon' => 'fa fa-angle-right',
					],
					'picture' => [
						'label' => 'Изображения',
						'icon' => 'fa fa-angle-right',
					],
					'unknown' => [
						'label' => 'Остальное',
						'icon' => 'fa fa-angle-right',
					],
				],
			],
			'guide' => [
				'label' => 'Справочники',
				'icon' => 'fa fa-list-alt',
				'items' => [
					'status' => [
						'label' => 'Статусы',
						'icon' => 'fa fa-angle-right',
					],
					'type' => [
						'label' => 'Типы',
						'icon' => 'fa fa-angle-right',
					],
					'category' => [
						'label' => 'Категории',
						'icon' => 'fa fa-angle-right',
					],
					'ext' => [
						'label' => 'Расширения',
						'icon' => 'fa fa-angle-right',
					],
				],
			],
			'config' => [
				'label' => 'Настройки',
				'icon' => 'fa fa-cog',
			],
		];
	}

	public function actionFile() {
		return $this->render('file', [
			'type' => $this->action
		]);
	}

	public function actionGuide() {
		return $this->render('guide', [
			'provider' => static::$grids[$this->action]
		]);
	}

	public function actionConfig() {
		return $this->render('config');
	}

	private static $grids = [
		'status' => 'FileStatusGridProvider',
		'type' => 'FileTypeGridProvider',
		'category' => 'FileCategoryGridProvider',
		'ext' => 'FileExtGridProvider',
	];
}