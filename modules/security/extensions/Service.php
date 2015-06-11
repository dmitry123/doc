<?php

namespace app\modules\security\extensions;

use app\core\Ext;

class Service extends Ext {

	public $action;

	public function actionMenu() {
		return [
			'guide' => [
				'label' => 'Справочники',
				'icon' => 'fa fa-list-alt',
				'items' => [
					'role' => [
						'label' => 'Роли',
						'icon' => 'fa fa-angle-right',
					],
					'module' => [
						'label' => 'Модули',
						'icon' => 'fa fa-angle-right',
					],
					'group' => [
						'label' => 'Группы',
						'icon' => 'fa fa-angle-right',
					],
					'privilege' => [
						'label' => 'Привилегии',
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

	public function actionGuide() {
		return $this->render('guide', [
			'provider' => static::$grids[$this->action]
		]);
	}

	public function actionConfig() {
		return $this->render('config');
	}

	private static $grids = [
		'role' => 'RoleGridProvider',
		'module' => 'ModuleGridProvider',
		'group' => 'GroupGridProvider',
		'privilege' => 'PrivilegeGridProvider',
	];
}