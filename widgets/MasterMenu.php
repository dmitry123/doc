<?php

namespace app\widgets;

use app\core\Module;
use app\core\Widget;

class MasterMenu extends Widget {

	public $id;

	public function run() {
		return $this->render("MasterMenu", [
			"items" => $this->getItems(Module::getAllowedModules()),
			"id" => $this->id
		]);
	}

	public function getItems($modules) {
		$items = [];
		foreach ($modules as $module) {
			$items[] = [
				"label" => $module["name"]
			];
		}
		return $items;
	}
}