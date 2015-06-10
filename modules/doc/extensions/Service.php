<?php

namespace app\modules\doc\extensions;

use app\core\Ext;

class Service extends Ext {

	public $js = [
		'js/doc.js'
	];

	public $css = [
		'css/doc.css'
	];

	function actionMenu() {
		return [
			'document' => [
				'label' => 'Документы',
				'icon' => 'fa fa-angle-right',
			],
			'template' => [
				'label' => 'Шаблоны',
				'icon' => 'fa fa-angle-right',
			],
			'guide' => [
				'label' => 'Справочники',
				'icon' => 'fa fa-angle-right',
			],
			'config' => [
				'label' => 'Настройки',
				'icon' => 'fa fa-angle-right',
			]
		];
	}

	public function actionDocument() {
		return $this->render('file', [
			'type' => 'document'
		]);
	}

	public function actionTemplate() {
		return $this->render('file', [
			'type' => 'template'
		]);
	}

	public function actionGuide() {
		return $this->render('guide');
	}

	public function actionConfig() {
		return $this->render('config');
	}
}