<?php

namespace app\modules\doc;

use app\core\Module;

class DocModule extends Module {

	public $menu = [
		"menu-doc-upload" => [
			"label" => "Загрузить",
			"icon" => "glyphicon glyphicon-upload",
			"options" => [
				"data-toggle" => "modal",
				"data-target" => "#test-modal"
			]
		],
		"menu-doc-find" => [
			"label" => "Найти",
			"icon" => "glyphicon glyphicon-search"
		]
	];

	public $layout = "main.php";
}