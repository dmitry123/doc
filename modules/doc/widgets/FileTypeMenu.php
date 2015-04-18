<?php

namespace app\modules\doc\widgets;

use app\widgets\TabMenu;

class FileTypeMenu extends TabMenu {

	public $style = self::STYLE_PILLS_STACKED;

	public $items = [
		"documents" => [
			"label" => "Документы",
			"href" => "@web/doc/file/view",
			"icon" => "glyphicon glyphicon-book"
		],
		"templates" => [
			"label" => "Шаблоны",
			"href" => "@web/doc/template/view",
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