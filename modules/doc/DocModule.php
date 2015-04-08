<?php

namespace app\modules\doc;

use app\core\Module;

class DocModule extends Module {

	public $menu = [
		"menu-doc-file" => [
			"label" => "Документы",
			"icon" => "glyphicon glyphicon-file",
			"options" => [
				"href" => "file"
			]
		],
		"menu-doc-upload" => [
			"label" => "Загрузить",
			"icon" => "glyphicon glyphicon-upload",
			"options" => [
				"data-toggle" => "modal",
				"data-target" => "#file-upload-modal"
			]
		],
		"menu-doc-find" => [
			"label" => "Найти",
			"icon" => "glyphicon glyphicon-search"
		]
	];

	public $layout = "main.php";
}