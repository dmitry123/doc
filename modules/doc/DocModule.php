<?php

namespace app\modules\doc;

use app\core\Module;

class DocModule extends Module {

	public $menu = [
		"menu-doc-file" => [
			"label" => "Главная",
			"icon" => "glyphicon glyphicon-file",
			"options" => [
				"href" => "doc/file/view"
			]
		],
        "menu-doc-master" => [
            "label" => "Мастер",
            "icon" => "glyphicon glyphicon-globe",
            "options" => [
                "data-toggle" => "modal",
                "data-target" => "#file-master-modal"
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
			"icon" => "glyphicon glyphicon-search",
			"options" => [
				"data-toggle" => "modal",
				"data-target" => "#file-search-modal"
			]
		]
	];

	public $layout = "main.php";
}