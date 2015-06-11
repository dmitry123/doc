<?php

namespace app\core;

use app\widgets\ControlMenu;

abstract class GridProviderWrite extends GridProvider {

	public $tableClass = 'table table-striped table-hover';

	public $pagination = [
		'pageSize' => 10,
		'page' => 0
	];

	public $menu = [
		'controls' => [
			'table-edit-icon' => [
				'label' => 'Редактировать',
				'icon' => 'fa fa-pencil',
			],
			'table-remove-icon' => [
				'label' => 'Удалить',
				'icon' => 'fa fa-trash fa-danger',
				'onclick' => 'confirmDelete()'
			],
		],
		'mode' => ControlMenu::MODE_ICON,
	];

	public $limits = [
		10, 20, 30
	];

	public $menuAlignment = 'right';
	public $menuWidth = 75;
}