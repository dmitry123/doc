<?php

namespace app\modules\doc\widgets;

use app\widgets\TabMenu;

class FileTypeMenu extends TabMenu {

	public $style = self::STYLE_PILLS_STACKED;

	public $items = [
		"documents" => [
			"label" => "Документы",
			"href" => "/doc/file",
			"icon" => "glyphicon glyphicon-book"
		],
		"templates" => [
			"label" => "Шаблоны",
			"href" => "/doc/template",
			"icon" => "glyphicon glyphicon-list-alt"
		]
	];
}