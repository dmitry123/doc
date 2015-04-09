<?php

namespace app\modules\doc\widgets;

use app\widgets\TabMenu;

class FileTypeMenu extends TabMenu {

	public $style = self::STYLE_PILLS_STACKED;

	public $items = [
		"documents" => [
			"label" => "Документы",
			"href" => "@web/doc/file",
			"icon" => "glyphicon glyphicon-book"
		],
		"templates" => [
			"label" => "Шаблоны",
			"href" => "@web/doc/template",
			"icon" => "glyphicon glyphicon-list-alt"
		],
		"tables" => [
			"label" => "Таблицы",
			"href" => "#",
			"icon" => "glyphicon glyphicon-list-alt"
		],
		"images" => [
			"label" => "Изображения",
			"href" => "#",
			"icon" => "glyphicon glyphicon-camera"
		],
	];
}