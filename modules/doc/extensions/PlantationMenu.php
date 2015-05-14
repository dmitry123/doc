<?php

namespace app\modules\doc\extensions;

use app\core\Ext;

class PlantationMenu extends Ext {

	function load() {
		return [
			"list" => [
				"label" => "Просмотр",
				"icon" => "fa fa-angle-right"
			],
			"guide" => [
				"label" => "Справочники",
				"icon" => "fa fa-angle-right"
			],
			"configuration" => [
				"label" => "Настройка",
				"icon" => "fa fa-angle-right"
			],
		];
	}
}