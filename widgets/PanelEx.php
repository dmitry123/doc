<?php

namespace app\widgets;

class PanelEx extends Panel {

	public $title = 'Таблица';

	public $controls = [
		'panel-insert-button' => [
			'class' => 'btn btn-primary btn-sm',
			'label' => 'Добавить',
			'icon' => 'glyphicon glyphicon-plus',
		],
	];

	public $bodyClass = 'panel-body clear';
	public $controlMode = ControlMenu::MODE_ICON;
}