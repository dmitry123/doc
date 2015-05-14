<?php

namespace app\components\widgets;

use app\components\Module;
use app\components\ModuleHelper;
use app\components\Widget;
use Yii;

class ModuleMenu extends Widget {

	public $absolute = true;
	public $stacked = false;

	public function run() {
		$modules = ModuleHelper::getMenuModules();
		foreach ($modules as $i => $module) {
			if (!isset($module["options"]) || !isset($module["options"]["data-url"])) {
				continue;
			}
			if (Yii::$app->controller->route != $module["options"]["data-url"]) {
				continue;
			}
			array_splice($module, $i, 1);
			break;
		}
		return $this->render("ModuleMenu2", [
			"modules" => $modules,
			"name" => ModuleHelper::currentModuleName(),
		]);
	}
}